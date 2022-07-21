<?php
require_once "lib/render.php";
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
        'search' => $_GET['search'] ?? 2,
        'sort' => $_GET['sort'] ?? false,
        'cart' => $_POST['cart-id'] ?? false
    ]);
}
