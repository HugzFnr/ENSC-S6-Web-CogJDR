<?php
    $conn = new PDO("mysql:host=127.0.0.1;dbname=cogjdr;charset=utf8", "root", "", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    function sql_query($c) {
        global $conn;

        return $conn->query($c);
    }

    function parms($string, $data) {
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

    function sql_select($table, $value, $where, $order=null, $distinct=false) {
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
        $where_builder = empty($where) ? "" : "WHERE ";
        $sep = "";
        foreach ($where as $k => $v) {
            $where_builder.= "$sep$k";

            if (is_array($v)) {
                $where_builder.= " IN (";
                $sep_ = "";
                foreach ($v as $v_) {
                    $where_builder.= "$sep_:$execute_index";
                    $execute_array[$execute_index++] = $v_;

                    $sep_ = ", ";
                }
                $where_builder.= ")";
            } else {
                $where_builder.= " = :$execute_index";
                $execute_array[$execute_index++] = $v;
            }
            
            $sep = " AND ";
        }

        // ORDER BY ..
        $order_builder = empty($order) ? "" : "ORDER BY ";
        $sep = "";
        if (is_array($order))
            foreach ($order as $k => $v) {
                $order_builder.= "$sep:$execute_index ";
                $execute_array[$execute_index++] = $k;

                $order_builder.= "$v";

                $sep = ", ";
            }

        /*-*/
        /*-echo "<code>".parms("$value_builder $table_builder $where_builder $order_builder", $execute_array)."</code><br>";*/
        /*-*/

        $r = $conn->prepare("$value_builder $table_builder $where_builder $order_builder");
        $r->execute($execute_array);
        return $r;
    }

    function sql_insert($table, $data) {
        global $conn;

        $keywords_builder = "";
        $tuple_builder = "";
        $sep = "";

        foreach ($data as $k => $v) {
            $keywords_builder.= "$sep$k";
            $tuple_builder.= "$sep:$k";
            $sep = ", ";
        }

        return $conn->prepare("INSERT INTO `$table` ($keywords_builder) VALUES ($tuple_builder)")->execute($data);
    }

    function sql_update($table, $data, $where) {
        global $conn;

        $change_builder = "";
        $sep = "";

        foreach ($data as $k => $v) {
            $change_builder.= "$sep$k = :$k";
            $sep = ", ";
        }

        $where_builder = "";
        $sep = "";

        foreach ($where as $k => $v) {
            $where_builder.= "$sep$k = :$k";
            $sep = " AND ";
        }

        return $conn->prepare("UPDATE `$table` SET $change_builder WHERE $where_builder")->execute($data + $where);
    }

    function sql_delete($table, $where) {
        global $conn;

        $where_builder = "";
        $sep = "";

        foreach ($where as $k => $v) {
            $where_builder.= "$sep$k = :$k";
            $sep = " AND ";
        }

        return $conn->prepare("DELETE FROM `$table` WHERE $where_builder")->execute($where);
    }

    function send_image($file, $name) {
        $name = str_replace("%", "_", rawurlencode(str_replace(" ", "-", $name)));

        $target_dir = "./images/";

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
            $r.= "Sorry, file already exists. ";
            $upload_success = false;
        }
        
        if($image_type != "jpg" && $image_type != "png" && $image_type != "jpeg" && $image_type != "gif" ) {
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
?>
