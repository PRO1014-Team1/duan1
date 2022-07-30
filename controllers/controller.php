<?php
require_once "lib/render.php";
require_once "lib/asset.php";
require_once "lib/session.php";
require_once "lib/template.php";
require_once "role.php";

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
    require_once 'models/product.php';
    require_once 'models/comment.php';
    require_once 'models/type.php';


    $product_id = $_GET['id'] ?? 0;
    $category_id = $_GET['category'] ?? false;
    $cart_id = $_POST['cart-id'] ?? false;
    $type_id = $_GET['type_id'] ?? false;
    $user = get_username();
    $types = get_type_data($product_id);
    $focus_product = false;
    $product = get_product($product_id);
    $comments = item_filter(get_comment(), "product_id", $product_id);
    $comment_count = count($comments);
    $view = get_view($product_id);
    $top_9_prod = item_sort(item_truncate(get_product(), 9), "view", 1);

    set_user_header();
    assets('detail');
    view('/user/detail', [
        'product_id' => $product_id,
        'category_id' => $category_id,
        'cart_id' => $cart_id,
        'type_id' => $type_id,
        'user' => $user,
        'product' => $product,
        'focus_product' => $focus_product,
        'types' => $types,
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

    $cart = $_SESSION['cart'] ?? null;
    set_user_header();
    assets('cart');
    // asset(' <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">');
      view('/user/cart', ['cart' => $cart]);
}

function checkout()
{
    require_once "models/product.php";
    require_once "models/type.php";
    require_once('models/database.php');
    require_once('models/order.php');

    set_user_header();
    assets("<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css' integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO' crossorigin='anonymous'>");

    $cart = $_SESSION['cart'];
    $cartItemCount = count($cart);
    $total = 0;
    view('/user/checkout', [
        'cart' => $cart,
        'cartItemCount' => $cartItemCount,
    ]);
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
    require_once 'models/type.php';
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

function news()
{
    require_once 'models/database.php';

    assets('user_header');
    assets('news');
    view('/user/news');
}

function library()
{
    require_once 'models/database.php';
    require_once 'models/order.php';
    require_once 'models/product.php';
    require_once 'models/type.php';

    assets('user_header');
    assets('library');
    assets('<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">');
    assets('<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js">');
    assets('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">');

    set_user_header();
    view('/user/library');
}

function readbook()
{
    require_once 'models/database.php';
    require_once 'models/order.php';
    require_once 'models/product.php';
    require_once 'models/type.php';

    assets('user_header');
    assets('readbook');
    // assets('<script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@2.14.305/build/pdf.min.js"></script>');
    assets('<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.14.305/pdf.min.js" integrity="sha512-dw+7hmxlGiOvY3mCnzrPT5yoUwN/MRjVgYV7HGXqsiXnZeqsw1H9n9lsnnPu4kL2nx2bnrjFcuWK+P3lshekwQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>');
    assets('<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.14.305/pdf.sandbox.min.js" integrity="sha512-3RD2dDO1yWFATw637hrRjYqNIeRnx8cWKI0EkFF8Ier8rdDeTJpJHCsl4/DSMdpKerU9LK5xJJgz/E7JtOi1Ow==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>');
    assets('<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.14.305/pdf.worker.entry.min.js" integrity="sha512-NJEHr6hlBM4MkVxJu+7FBk+pn7r+KD8rh+50DPglV/8T8I9ETqHJH0bO7NRPHaPszzYTxBWQztDfL6iJV6CQTw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>');
    assets('<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.14.305/pdf.worker.min.js" integrity="sha512-fahFaRPTP2xrdxAbzgG31V4Vr+Ga/hp4gQu3ZBq83bhKO10NoWfTJ20OWg9ufEyT1Y4ZyCuh9wLHY9CHi6l95Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>');
    assets('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.14.305/pdf_viewer.min.css" integrity="sha512-USGasHs0SUBcT/vnWD0C6wMIvMGRf4lvvSKNbKvShfGdgT2pxHWNvClLLZwPqygPOiQ4HEIM51R/8bguqWyNvQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />');
    assets('<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.14.305/pdf_viewer.min.js" integrity="sha512-x+RmXhJTdSyOC9nVUvKVwtTsfTFtsbWPNeTuI3OlA7kLvyxG39BiWaT5VU5xENbHq25k3KFPdGR5OcO2/LTxOg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>');
    set_user_header();
    view('/user/readbook');
}
    
// controller cho admin end

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


function dashboard()
{
    require_once 'models/database.php';
    require_once 'models/order.php';
    assets('admin_header');
    assets('<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.2/chart.min.js"></script>');
    assets('');
    assets('dashboard');
    set_admin_header();
    view('/admin/dashboard');
}
