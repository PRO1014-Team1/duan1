<?php
require_once "lib/render.php";
require_once "lib/asset.php";
require_once "role.php";


function hang_hoa_index()
{
    require_once "models/product.php";
    $hang_hoa = hang_hoa_all();
    view('hang_hoa_index', ['hang_hoa' => $hang_hoa]);
}

function home()
{
    require_once "models/product.php";
    require_once "models/comment.php";

    assets('home');
    view('home', [
        'popular_products' => item_sort(get_product(), "view", 1),
        'products' => get_product(),
        'popular_products_top_4' =>  item_sort(item_truncate(get_product(), 4), "view", 1), // lấy 4 sản phẩm có nhiều view nhât
        'popular_products_top_10' => item_sort(item_truncate(get_product(), 10), "view", 1), // lấy 10 sản phẩm có nhiều view nhât
        'product_count' => get_product_count(), // lấy tổng số sản phẩm
        'category_filter' => $_GET['category'] ?? 'all', // lấy id của danh mục được chọn
        'categories' => pdo_query('SELECT `category`.`name`, `category`.`id`, COUNT(`category_id`) AS count FROM `product` JOIN `category` ON `product`.`category_id` = `category`.`id` GROUP BY `category`.`name`, `category`.`id`'), // lấy danh sách loại hàng và số lượng
        'search' => $_GET['search'] ?? false,
        'sort' => $_GET['sort'] ?? false,
        'cart' => $_POST['cart-id'] ?? false
    ]);
}

function login()
{
    require_once "models/database.php";
    assets('login');
    view('login');
}

function logout()
{
    view('logout');
}

function path_not_found()
{
    assets('404');
    view('404');
}

function detail()
{
    require_once './models/product.php';
    require_once './models/comment.php';
    assets('detail');
    view('detail', [
        'id' => $_GET["id"] ?? 0,
        'category' => $_GET['category'] ?? '',
        'product' => pdo_query("SELECT * FROM `product` WHERE `product_id` = ?", [$_GET['id'] ?? 0]),
        'comments' => item_sort(item_filter(get_comment(), "product_id", $_GET["id"] ?? 0), 'date', 1),
        'comment_count' => get_comment_count("`product_id` = {$_GET["id"]}"),
        'view' => get_view($_GET["id"] ?? 0),
        'top_9_prod' => item_truncate(item_filter(get_product(), "category_id", $_GET["id"] ?? 0), 9),
    ]);
}

function cart()
{
    assets('cart');
    view('cart');
}

function profile()
{
    require_once "models/database.php";
    assets('profile');
    view('profile');
}

function register()
{
    require_once "models/database.php";
    assets('register');
    view('register');
}