<?php
//Định tuyến cho đường dẫn của website

$routes = [];
/*
--Khai báo hàm route định tuyến website
--$path là đường dẫn
--$callback hành động ứng với đường dẫn
*/
function route($path, $callback)
{
    global $routes;
    $routes[$path] = $callback;
}

/*
--Khai báo hàm run
--Hàm này sẽ xác định các đường dẫn ($path) thích hợp để chạy hành động ($callback)
*/
function run()
{
    global $routes;

    //lấy ra đường dẫn hiện tại của website
    $requestURI = parse_url($_SERVER['REQUEST_URI']);
    $uri = $requestURI['path'];

    //khai báo biến xác định có đường dẫn không, nếu không có đường dẫn thì sẽ là false
    $found = false;
    foreach ($routes as $path => $callback) {
        if ($path !== $uri) {
            continue;
        }
        $found = true;
        $callback();
    }

    if ($found == false) {
        $fileNotFound = $routes['/404'];
        return $fileNotFound();
    }
}
