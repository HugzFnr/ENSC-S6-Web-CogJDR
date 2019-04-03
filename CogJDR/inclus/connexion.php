<?php
    $conn = new PDO("mysql:host=127.0.0.1;dbname=cogjdr;charset=utf8", "root", "", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    function sql_query($c) {
        global $conn;

        return $conn->query($c);
    }

    function prepared($string, $data) {
        $indexed = $data == array_values($data);
        foreach ($data as $k=>$v) {
            if (is_string($v))
                $v = "'$v'";
            if ($indexed)
                $string = preg_replace('/\?/', $v, $string, 1);
            else
                $string = str_replace(":$k", $v, $string);
        }
        return $string;
    }

    function prepare_execute($conn, $string, $data) {
        /*-*/
        /*-echo "<code class=\"sql-request\">".prepared($string, $data)."</code><br>\n";*/
        /*-*/

        $r = $conn->prepare($string);
        $r->execute($data);
        return $r;
    }

    function build_where($where, &$execute_array, &$execute_index='a') {
        $where_builder = empty($where) ? "WHERE 1" : "WHERE ";
        $sep = "";

        foreach ($where as $k => $v) {
            if (is_string($k) && strpos($k, "::") !== false)
                $where_builder.= "$sep".str_replace("::", ".", $k);
            else
                $where_builder.= "$sep$k";

            if (is_array($v)) {
                $where_builder.= " IN (";
                $sep_ = "";
                foreach ($v as $v_) {
                    if (strpos($v_, "::") !== false)
                        $where_builder.= "$sep_".str_replace("::", ".", $v_);
                    else {
                        $where_builder.= "$sep_:$execute_index";
                        $execute_array[$execute_index++] = $v_;
                    }

                    $sep_ = ", ";
                }
                $where_builder.= ")";
            } else {
                if (strpos($v, "::") !== false)
                    $where_builder.= "= ".str_replace("::", ".", $v);
                else {
                    $where_builder.= "= :$execute_index";
                    $execute_array[$execute_index++] = $v;
                }
            }

            $sep = " AND ";
        }

        return $where_builder;
    }

    function sql_select($table, $value="*", $where=array(), $order=null, $distinct=false) {
        global $conn;

        $execute_array = array();
        $execute_index = 'a';

        // SELECT ..
        $value_builder = empty($distinct) ? "SELECT " : "SELECT DISTINCT ";
        if ($value == "*" || empty($value))
            $value_builder.= "*";
        elseif (is_array($value))
            $value_builder.= join(", ", $value);
        else
            $value_builder.= $value;

        // FROM ..
        $table_builder = "FROM `".(is_array($table) ? join("` JOIN `", $table) : $table)."`";

        // WHERE ..
        $where_builder = build_where($where, $execute_array, $execute_index);

        // ORDER BY ..
        $order_builder = empty($order) ? "" : "ORDER BY ";
        $sep = "";
        if (is_array($order))
            foreach ($order as $k => $v) {
                $order_builder.= "$sep$k $v";
                $sep = ", ";
            }

        /*$r = $conn->prepare("$value_builder $table_builder $where_builder $order_builder");
        $r->execute($execute_array);
        return $r;*/
        return prepare_execute($conn, "$value_builder $table_builder $where_builder $order_builder", $execute_array);
    }

    function sql_insert($table, $data, $multiple=null, $id_return=false) {
        global $conn;

        $keywords_builder = "";
        $tuple_builder = "";
        $sep = "";
        $execute_array = array();

        if (!$multiple) {
            foreach ($data as $k => $v) {
                $keywords_builder.= "$sep$k";
                $tuple_builder.= "$sep:$k";
                $sep = ", ";
            }

            $execute_array = $data;
        } else {
            $tuple_builder = array();

            foreach ($data as $key => $key_name) {
                $keywords_builder.= "$sep$key_name";

                foreach ($multiple as $index => $tuple) {
                    if (empty($tuple_builder[$index]))
                        $tuple_builder[$index] = "$sep:$key_name$index";
                    else
                        $tuple_builder[$index].= "$sep:$key_name$index";

                    if (empty($execute_array[$key_name.$index]))
                        $execute_array[$key_name.$index] = $tuple[$key];
                    else
                        $execute_array[$key_name.$index].= $tuple[$key];
                }
                $sep = ", ";
            }

            $tuple_builder = join("), (", $tuple_builder);
        }

        //$r = $conn->prepare("INSERT INTO `$table` ($keywords_builder) VALUES ($tuple_builder)")->execute($execute_array);
        $r = prepare_execute($conn, "INSERT INTO `$table` ($keywords_builder) VALUES ($tuple_builder)", $execute_array);

        if (!$id_return)
            return $r;

        return sql_select($table, "MAX($id_return)")->fetch()[0];
    }

    function sql_update($table, $data, $where) {
        global $conn;

        $change_builder = "";
        $sep = "";

        foreach ($data as $k => $v) {
            $change_builder.= "$sep$k = :$k";
            $sep = ", ";
        }

        $where_builder = build_where($where, $data);

        //return $conn->prepare("UPDATE `$table` SET $change_builder WHERE $where_builder")->execute($data + $execute_array);
        return prepare_execute($conn, "UPDATE `$table` SET $change_builder $where_builder", $data);
    }

    function sql_delete($table, $where) {
        global $conn;

        $execute_array = array();
        $where_builder = build_where($where, $execute_array);
        
        //return $conn->prepare("DELETE FROM `$table` WHERE $where_builder")->execute($execute_array);
        return prepare_execute($conn, "DELETE FROM `$table` WHERE $where_builder", $execute_array);
    }

    function send_image($file, $name, $target_dir="./images/") {
        $name = str_replace("%", "_", rawurlencode(str_replace(" ", "-", $name)));

        $image_type = strtolower(pathinfo($target_dir.basename($file["name"]), PATHINFO_EXTENSION));
        $image_size = getimagesize($file["tmp_name"]);

        $target_file = "$target_dir$name.$image_type";

        $upload_success = true;
        $r = "";

        if ($image_size !== false) {
            $r.= "File is an image - ".$image_size["mime"].". ";
            $upload_success = true;
        } else {
            $r.= "File is not an image. ";
            $upload_success = false;
        }

        if (file_exists($target_file)) {
            $r.= "File existed. ";
            unlink($target_file);
        }

        if ($image_type != "jpg" && $image_type != "png" && $image_type != "jpeg" && $image_type != "gif" ) {
            $r.= "Sorry, only JPG, JPEG, PNG & GIF files are allowed. ";
            $upload_success = false;
        }

        if ($upload_success) {
            if (move_uploaded_file($file["tmp_name"], $target_file))
                $r.= "The file ".basename($file["name"])." has been uploaded. ";

            else
                $r.= "Sorry, there was an error uploading your file. ";
        }

        return array('msg' => $r, 'success' => $upload_success, 'fileName' => "$name.$image_type");
    }

    function send_file($file, $name, $target_dir, $ext=array()) {
        $name = str_replace("%", "_", rawurlencode(str_replace(" ", "-", $name)));

        $file_type = strtolower(pathinfo($target_dir.basename($file["name"]), PATHINFO_EXTENSION));

        $target_file = "$target_dir$name.$file_type";

        $upload_success = true;
        $r = "";

        if (file_exists($target_file)) {
            $r.= "File existed. ";
            unlink($target_file);
        }

        if (!empty($ext) && !in_array($file_type, $ext)) {
            $r.= "Sorry, only ".join(", ", $ext)." files are allowed. ";
            $upload_success = false;
        }

        if ($upload_success) {
            if (move_uploaded_file($file["tmp_name"], $target_file))
                $r.= "The file ".basename($file["name"])." has been uploaded. ";

            else
                $r.= "Sorry, there was an error uploading your file. ";
        }

        return array('msg' => $r, 'success' => $upload_success, 'fileName' => "$name.$file_type");
    }

    function recup_enum($table,$colonne) {
        $sql = "SHOW COLUMNS FROM `$table` LIKE '$colonne'";
        $result = sql_query($sql);
        $row = $result->fetch();
        $type = $row['Type'];
        preg_match('/enum\((.*)\)$/', $type, $matches);
        $vals = explode(',', $matches[1]);
        return ($vals);
    }
?>
