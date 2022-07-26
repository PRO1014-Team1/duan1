<?php
require_once "lib/render.php";
require_once "lib/asset.php";
require_once "lib/session.php";
require_once "lib/template.php";
require_once "role.php";

// function hang_hoa_index()
// {
//     require_once "models/product.php";

//     set_user_header();
//     $hang_hoa = hang_hoa_all();
//     view('/user/hang_hoa_index', ['hang_hoa' => $hang_hoa]);
// }

function home()
{
    require_once "models/product.php";
    require_once "models/comment.php";
    require_once "models/type.php";

    $popular_products = item_sort(get_product(), 'view', 1);
    $products = get_product();
    $popular_products_top_4 = item_truncate($popular_products, 4); // lấy 4 sản phẩm có nhiều view nhât
    $popular_products_top_10 = item_truncate($popular_products, 10); // lấy 10 sản phẩm có nhiều view nhât
    $product_count = get_product_count(); // lấy tổng số sản phẩm
    $category_filter = $_GET['category'] ?? 'all'; // lấy id của danh mục được chọn
    $categories = pdo_query('SELECT `category`.`name`, `category`.`id`, COUNT(`category_id`) AS count FROM `product` JOIN `category` ON `product`.`category_id` = `category`.`id` GROUP BY `category`.`name`, `category`.`id`'); // lấy danh sách loại hàng và số lượng
    $search = $_GET['search'] ?? false;
    $sort = $_GET['sort'] ?? false;


    set_user_header();
    assets('home');
    view('/user/home', [
        'products' => $products,
        'popular_products' => $popular_products,
        'popular_products_top_4' => $popular_products_top_4,
        'popular_products_top_10' => $popular_products_top_10,
        'product_count' => $product_count,
        'categories' => $categories,
        'category_filter' => $category_filter,
        'search' => $search,
        'sort' => $sort,
    ]);
}

function login()
{
    require_once "models/database.php";

    set_user_header();
    assets('login');
    view('/user/login');
}

function logout()
{
    $_SESSION = array();
}

function path_not_found()
{
    set_user_header();
    assets('404');
    view('/404');
}

function detail()
{
    require_once './models/product.php';
    require_once './models/comment.php';

    $id = $_GET['id'] ?? 0;
    $category = $_GET['category'] ?? false;
    $product = pdo_query('SELECT * FROM `product` WHERE `id` = ?', [$id]);
    $comments = item_sort(item_filter(get_comment(), "product_id", $_GET["id"] ?? 0), 'date', 1);
    $comment_count = get_comment_count("product_id", $id);
    $view = get_view($id);
    $top_9_prod = item_sort(item_truncate(get_product(), 9), "view", 1);

    set_user_header();
    assets('detail');
    view('/user/detail', [
        'id' => $id,
        'category' => $category,
        'product' => $product,
        'comments' => $comments,
        'comment_count' => $comment_count,
        'view' => $view,
        'top_9_prod' => $top_9_prod
    ]);
}

function cart()
{
    require_once "models/product.php";
    require_once "models/type.php";
    set_user_header();
    assets('cart');
    view('/user/cart');
}

function checkout()
{
    require_once "models/product.php";
    require_once "models/type.php";
    
    require_once('models/database.php');    
    require_once('./models/helpers.php');  
    set_user_header();
    assets('checkout');
    view('/user/checkout');
}

function profile()
{
    require_once "models/database.php";

    set_user_header();
    assets('profile');
    view('/user/profile');
}

function register()
{
    require_once "models/database.php";

    set_user_header();
    assets('register');
    view('/user/register');
}

// controller cho admin

function product()
{
    if (deny_access($_SESSION['role'])) {
        return;
    }
    require_once 'models/product.php';
    require_once 'models/comment.php';
    require_once 'models/category.php';

    assets('admin_header');
    assets('product');
    set_admin_header();
    view('/admin/product');
}


function add_product()
{
    if (deny_access($_SESSION['role'])) {
        return;
    }
    require_once 'models/category.php';

    assets('admin_header');
    assets('add_product');
    set_admin_header();
    view('/admin/add-product');
}

function edit_product()
{
    if (deny_access($_SESSION['role'])) {
        return;
    }
    require_once 'models/product.php';

    $edit_id = $_GET['id'] ?? false;
    $edit_product = item_filter(get_product(), "product_id", $edit_id);
    $category = get_all_category();

    assets('admin_header');
    assets('edit-product');
    set_admin_header();
    view('/admin/edit-product', [
        'edit_id' => $edit_id,
        'edit_product' => $edit_product,
        'category' => $category
    ]);
}


function category()
{
    if (deny_access($_SESSION['role'])) {
        return;
    }
    require_once 'models/category.php';
    require_once 'models/product.php';

    assets('admin_header');
    assets('category');
    set_admin_header();
    view('/admin/category', [
        'categories' => get_all_category(),
        'selected' => $_POST['selected'] ?? null,
        'delete_selected' => $_POST['delete_selected'] ?? false,
        'delete_one' => $_POST['delete_one'] ?? false
    ]);
}


function add_category()
{
    if (deny_access($_SESSION['role'])) {
        return;
    }
    require_once 'models/category.php';
    require_once 'models/database.php';

    set_admin_header();
    assets('add-category');
    view('/admin/add-category');
}

function edit_category()
{
    if (deny_access($_SESSION['role'])) {
        return;
    }
    require_once 'models/category.php';
    require_once 'models/database.php';

    $edit_id = $_GET['id'];
    $edit_category = get_category($edit_id)[0];

    set_admin_header();
    assets('edit-category');
    view('/admin/edit-category', ['edit_category' => $edit_category, 'edit_id' => $edit_id]);
}

function comment()
{
    if (deny_access($_SESSION['role'])) {
        return;
    }
    require_once 'models/comment.php';
    require_once 'models/product.php';

    $product = get_product();
    $selected = $_POST['selected'] ?? null;

    assets('admin_header');
    assets('comment');
    set_admin_header();
    view('/admin/comment', [
        'product' => $product,
        'selected' => $selected,
        'delete_selected' => $_POST['delete_selected'] ?? false,
        'delete_one' => $_POST['delete_one'] ?? false
    ]);
}

function comment_detail()
{
    if (deny_access($_SESSION['role'])) {
        return;
    }
    require_once 'models/comment.php';

    $id = $_GET['id'] ?? 0;
    $selected = $_POST['selected'] ?? null;
    $comment = get_comment("", "", "product_id = " . $id);

    assets('admin_header');
    assets('comment_detail');
    set_admin_header();
    view('/admin/comment_detail', [
        'id' => $id,
        'comment' => $comment,
        'selected' => $selected,
        'delete_selected' => $_POST['delete_selected'] ?? false,
        'delete_one' => $_POST['delete_one'] ?? false
    ]);
}

function customer()
{
    if (deny_access($_SESSION['role'])) {
        return;
    }
    require_once 'models/database.php';
    require_once 'models/customer.php';

    $selected = $_POST['selected'] ?? null;
    $delete_selected = $_POST['delete_selected'] ?? false;
    $delete_one = $_POST['delete_one'] ?? false;

    assets('admin_header');
    assets('customer');
    set_admin_header();
    view('/admin/customer', [
        'selected' => $selected,
        'delete_selected' => $delete_selected,
        'delete_one' => $delete_one
    ]);
}

function edit_customer()
{
    if (deny_access($_SESSION['role'])) {
        return;
    }
    require_once 'models/ustomer.php';
    require_once 'models/database.php';

    $user = pdo_execute('SELECT * FROM users WHERE username = ?', [$_GET['username']]);
    $genders = ['Nam', 'Nữ', 'Khác'];
    $path = "";

    assets('admin_header');
    assets('edit_customer');
    set_admin_header();
    view('/admin/edit-customer', ['user' => $user, 'path' => $path, 'genders' => $genders]);
}

function statistic()
{
    if (deny_access($_SESSION['role'])) {
        return;
    }
    require_once 'models/statistic.php';
    require_once 'models/product.php';
    require_once 'models/comment.php';
    require_once 'models/customer.php';

    $product = get_product();
    $comment = get_comment();
    $customer = get_customer();
    $selected = $_POST['selected'] ?? null;
    $categories = pdo_query('SELECT DISTINCT `category`.`name`, `category`.`id`, COUNT(`category_id`) AS count FROM `product` JOIN `category` ON `product`.`category_id` = `category`.`id` GROUP BY `category`.`name`, `category`.`id`'); // lấy danh sách loại hàng và số lượng

    assets('admin_header');
    assets('statistic');
    set_admin_header();
    view('/admin/statistic', [
        'product' => $product,
        'comment' => $comment,
        'customer' => $customer,
        'categories' => $categories,
        'selected' => $selected
    ]);
}

function graph()
{
    if (deny_access($_SESSION['role'])) {
        return;
    }
    require_once 'models/database.php';
    require_once 'models/product.php';

    $categories = pdo_query('SELECT `category`.`name`, `category`.`id`, COUNT(`category_id`) AS count FROM `product` JOIN `category` ON `product`.`category_id` = `category`.`id` GROUP BY `category`.`name`, `category`.`id`'); // lấy danh sách loại hàng và số lượng
    $categoryView =  pdo_query('SELECT `category`.`name`,  SUM( `view`) as view FROM `product` JOIN `category` ON `product`.`category_id` = `category`.`id` GROUP BY `category`.`name`'); // lấy danh sách loại hàng và số lượng
    $comment = pdo_query('SELECT `category`.`name`,  COUNT(DISTINCT `content`) as comment_count FROM `product` JOIN `comment` ON `product`.`product_id` = `comment`.`product_id` JOIN `category` ON `product`.`category_id` = `category`.`id` GROUP BY `category`.`name`');
    $product = get_product();

    assets('admin_header');
    assets('graph');
    set_admin_header();
    view('/admin/graph', [
        'categories' => $categories,
        'categoryView' => $categoryView,
        'comment' => $comment,
        'product' => $product
    ]);
}

function news()
{
    require_once 'models/database.php';

    assets('user_header');
    assets('news');
    set_user_header();
    view('/user/news', ["article_id" => $_GET['id'] ?? 0]);
}
