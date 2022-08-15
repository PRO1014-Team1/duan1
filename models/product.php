<?php
require_once "database.php";


function get_product($product_id = null)
{
    $sql = "SELECT `product`.*, COUNT(`view`.`username`) AS `view` FROM `product` LEFT JOIN `view` ON `product`.`product_id` = `view`.`product_id` GROUP BY `product`.`name`";
    if ($product_id != null) {
        $sql .= " HAVING `product`.`product_id` = $product_id";
        $data = pdo_query_once($sql);
    } else {
        $data = pdo_query($sql);
    }
    return $data;
}

function get_product_count()
{
    $sql = "SELECT COUNT(*) AS count FROM `product`";
    $data = pdo_query_once($sql);
    return $data['count'];
}

function delete_product($product_id)
{
    //if id is an array, use recursion
    if (is_array($product_id)) {
        foreach ($product_id as $id) {
            delete_product($id);
        }
    } else {
        $sql = "DELETE FROM `product` WHERE `product_id` = ?";
        pdo_execute($sql, $product_id);
    }
}

//them view
function add_view($product_id)
{
    //check if this product already has already been viewed by user
    $sql = "SELECT * FROM `view` WHERE `product_id` = ? AND `username` = ?";
    $data = pdo_query($sql, [$product_id, $_SESSION['username']]);

    if (count($data) == 0) {
        //log this view
        $sql = "INSERT INTO `view` (`product_id`, `username`) VALUES (?, ?)";
        pdo_execute($sql, [$product_id, $_SESSION['username']]);
    }
}

function get_product_by_time($start = false, $end = false)
{
    if (!$end) {
        $end = date('Y-m-t');
    }
    if (!$start) {
        return get_product();
    } else {
        $sql = "SELECT * FROM `product` WHERE import_date BETWEEN ? AND ?";
        $result = pdo_query($sql, [$start, $end]);
    }
    return $result;
}

function get_product_range($order_by = "week")
{
    $prev_order = 0;
    $cur_order = 0;
    switch ($order_by) {
        case 'week':
            $prev_order = get_product_by_time(date('Y-m-d', strtotime('-1 week')), date('Y-m-d', strtotime('-1 day')));
            $cur_order = get_product_by_time(date('Y-m-d', strtotime('-1 day')), date('Y-m-d'));
            break;
        case 'month':
            $cur_order = get_product_by_time(date('Y-m-01'));
            $prev_order = get_product_by_time(date('Y-m-01', strtotime('-1 month')), date('Y-m-t', strtotime('-1 month')));
            break;
        case 'year':
            $cur_order = get_product_by_time(date('Y-01-01'), date('Y-12-31'));
            $prev_order = get_product_by_time(date('Y-01-01', strtotime('-1 year')), date('Y-12-31', strtotime('-1 year')));
            break;
        case 'all':
            $cur_order = get_product_by_time();
            $prev_order = get_product_by_time();
            break;
    }
    return [$prev_order, $cur_order];
}

function get_view($product_id)
{
    $sql = "SELECT COUNT(*) AS `view` FROM `view` WHERE `product_id` = ?";
    return pdo_query_once($sql, [$product_id])["view"];
}
