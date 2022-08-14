<?php

$file = reset($_FILES);
$file_name = $file['name'];
$file_tmp = $file['tmp_name'];
$file_size = $file['size'];
$file_error = $file['error'];
$file_type = $file['type'];
$file_ext = explode('.', $file_name);
$file_ext = strtolower(end($file_ext));
$allowed = array('jpg', 'jpeg', 'png', 'webp', "pdf", "mp3", "wav", "mp4", "ogg", "webm");
if (in_array($file_ext, $allowed)) {
    if ($file_error === 0) {
        //nếu là file ảnh
        if (in_array($file_ext, ['jpg', 'jpeg', 'png', 'webp'])) {
            if ($file_size <= 2097152) {
                $file_name_new = ($_POST['username'] ?? $_POST["product_name"] ?? "") . '.' . $file_ext;
                $path .=  $file_name_new;
                if (move_uploaded_file($file_tmp, $path)) {
                    echo '<script>alert("Upload thành công")</script>';
                } else {
                    echo '<script>alert("Upload thất bại")</script>';
                }
            } else {
                echo '<script>alert("Kích thước file quá lớn")</script>';
            }
        }
        //nếu là file pdf
        elseif ($file_ext == "pdf") {
            // file should be smaller than 200mb
            if ($file_size <= 20000000) {
                $file_name_new = ($_POST["product_name"] ?? "") . '.' . $file_ext;
                $path .= $file_name_new;
                if (move_uploaded_file($file_tmp, $path)) {
                    echo '<script>alert("Upload thành công")</script>';
                } else {
                    echo '<script>alert("Upload thất bại")</script>';
                }
            } else {
                echo '<script>alert("Kích thước file quá lớn")</script>';
            }
        }
        //nếu là file audio
        elseif ($file_ext == "mp3" || $file_ext == "wav") {
            // file should be smaller than 50mb
            if ($file_size <= 5000000) {
                $file_name_new = ($_POST["product_name"] ?? "") . '.' . $file_ext;
                $path .=  $file_name_new;
                if (move_uploaded_file($file_tmp, $path)) {
                    echo '<script>alert("Upload thành công")</script>';
                } else {
                    echo '<script>alert("Upload thất bại")</script>';
                }
            } else {
                echo '<script>alert("Kích thước file quá lớn")</script>';
            }
        } else {
            echo '<script>alert("Có lỗi xảy ra")</script>';
        }
    }
} else {
    echo '<script>alert("Không đúng định dạng")</script>';
}
