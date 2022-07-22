<?php

function get_product_price($category, $cond)
{
    $sql = "SELECT price FROM `product`";
    $sql .= " WHERE category_id = ?";
    $data = pdo_query($sql, [$category]);
    if($cond == "HIGH") {
        $sql = "SELECT MAX(price) AS price FROM `product`";
        $sql .= " WHERE category_id = ?";
        $data = pdo_query($sql, [$category])[0]['price'];
    } else if($cond == "LOW") {
        $sql = "SELECT MIN(price) AS price FROM `product`";
        $sql .= " WHERE category_id = ?";
        $data = pdo_query($sql, [$category])[0]['price'];
    } else if($cond == "AVG") {
        $sql = "SELECT AVG(price) AS price FROM `product`";
        $sql .= " WHERE category_id = ?";
        $data = pdo_query($sql, [$category])[0]['price'];
    }
    return $data;
}
