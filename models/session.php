<?php
function set_session()
{
    if (session_status() == PHP_SESSION_NONE) {
        ob_start();
        session_start();
    }
    $_SESSION['identity'] = $_SERVER['REMOTE_ADDR']; // IP address
    $_SESSION['errors'] = false;
    $_SESSION['role'] = 2; //khách xem
}

function get_role()
{
    return $_SESSION['role'] ?? 2;
}

function get_identity()
{
    return $_SESSION['identity'] ?? false;
}
