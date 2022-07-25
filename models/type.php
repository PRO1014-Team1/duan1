<?php

function get_type_data($product_id)
{
   $sql = "SELECT * FROM type_detail WHERE `product_id` = ?";
   $data = pdo_query($sql, [$product_id]);
   return $data;
}

function get_type_name($type_id)
{
   $sql = "SELECT * FROM `type` WHERE `type_id` = ?";
   $data = pdo_query_once($sql, [$type_id]);
   return $data['name'];
}

function discount($price, $discount)
{
  return $discount == 0 ? 0 : $price - ($price * $discount);
}
