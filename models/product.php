<?php
require_once "database.php";


function get_product()
{
    $sql = "SELECT `product`.*, COUNT(`view`.`username`) AS `view` FROM `product` LEFT JOIN `view` ON `product`.`product_id` = `view`.`product_id` GROUP BY `product`.`name`";
    $data = pdo_query($sql);
    return $data;
}

function get_product_count()
{
    $sql = "SELECT COUNT(*) AS count FROM `product`";
    $data = pdo_execute($sql);
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
        pdo_execute($sql, [$product_id]);
        redirect('product');
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

function get_view($product_id)
{
    $sql = "SELECT COUNT(*) AS `view` FROM `view` WHERE `product_id` = ?";
    return pdo_query_once($sql, [$product_id])["view"];
}

?>