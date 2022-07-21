<?php

//
function set_meta()
{
    $meta_header = "views/templates/header.php";
    if (file_exists($meta_header)) {
        require $meta_header;
    } else {
        echo 'không tồn tại trang ngày';
    }
}
function set_user_header()
{
    $user_header = "views/templates/user_header.php";
    if (file_exists($user_header)) {
        require $user_header;
    } else {
        echo 'không tồn tại trang ngày';
    }
}

function set_admin_header()
{
    $admin_header = "views/templates/admin_header.php";
    if (file_exists($admin_header)) {
        require $admin_header;
    } else {
        echo 'không tồn tại trang ngày';
    }
}

function set_header($role)
{
    if ($role == 1) {
        set_admin_header();
    } else {
        set_user_header();
    }
}


function set_footer()
{
    $path_footer = "views/templates/footer.php";
    if (file_exists($path_footer)) {
        require $path_footer;
    } else {
        echo 'không tồn tại trang ngày';
    }
}
