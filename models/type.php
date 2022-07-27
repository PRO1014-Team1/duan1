<?php

function get_type_data($product_id, $type_id = null)
{
   $sql = "SELECT * FROM type_detail WHERE `product_id` = ?";
   if($type_id) {
      $sql .= " AND `type_id` = ?";
   }
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
  return $discount == 0 ? $price : $price - ($price * $discount);
}
