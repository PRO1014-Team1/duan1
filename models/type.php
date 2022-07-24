<?php

 function get_type_data($type_id, $product_id){
    $sql = "SELECT * FROM type_detail WHERE `product_id` = ? AND `type_id` = ?";
    $data = pdo_query($sql, [$product_id, $type_id]);
    return $data ? $data : [];
 }

 function get_type_name($type_id){
    $sql = "SELECT * FROM `type` WHERE `type_id` = ?";
    $data = pdo_query_once($sql, [$type_id]);
    return $data['name'];
 }

 function discount($price, $discount){
   
    return $price - ($price * $discount);
 }