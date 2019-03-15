<?php
    $conn = new PDO("mysql:host=127.0.0.1;dbname=cogjdr;charset=utf8", "root", "", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    function sql_query($c) {
        global $conn;

        return $conn->query($c);
    }

    function sql_select($table, $values, $where, $more="") {
        global $conn;

        $values_builder = "";
        if ($values == "*" || $values == -1) {
            $values_builder = "*";
            //$values = array();
        } elseif (is_array($values)) {
            $sep = "";

            foreach ($values as $v) {
                $values_builder.= "$sep$v";
                $sep = ", ";
                //$values = array();
            }
        } else {
            $values_builder = $values;
            //$values = array();
        }

        $where_builder = "";
        $sep = "";

        foreach ($where as $k => $v) {
            $where_builder.= "$sep$k";

            if (empty($v)) {
                unset($where[$k]);
            } elseif (is_array($v)) {
                $where[$k] = join(", ", $where[$k]);
                $where_builder.= " IN (:$k)";
            } else
                $where_builder.= " = :$k";
            
            $sep = " AND ";
        }

        $table_builder = "";
        $sep = "";

        if (is_array($table)) {
            foreach ($table as $v) {
                $table_builder.= "$sep`$v`";
                $sep = " JOIN ";
            }
            $table = array();
        } else {
            $table_builder = "`$table`";
            $table = array();
        }
        
        if (empty($where)) {
            $r = $conn->prepare("SELECT $values_builder FROM $table_builder $more");
            $r->execute();
        } else {
            $r = $conn->prepare("SELECT $values_builder FROM $table_builder WHERE $where_builder $more");

            echo "<br><br>";
            var_dump($r);
            echo "<br><br>";
            var_dump($where);
            echo "<br><br>";

            $r->execute($where);
        }
        
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

    function envoi_image($file, $name) {
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

        if (512000 < $file["size"]) {
            $r.= "Sorry, your file is too large. ";
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

        return array('msg' => $r, 'success' => true, 'fileName' => "$name.$image_type");
    }
?>
