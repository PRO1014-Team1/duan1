<?php

function get_comment($id = null)
{
    $sql = "SELECT * FROM comment";
    if ($id) {
        $sql .= " WHERE comment_id = {$id}";
    }
    $data = pdo_query($sql);
    return $data;
}


function add_comment($name, $product, $content)
{
    $sql = "INSERT INTO `comment`(`content`, `username`, `product_id`, `date`) VALUES (?, ?, ?, ?)";
    $data = pdo_execute($sql, $content, $name, $product, date('Y-m-d H:i:s'));
    return $data;
}

function get_comment_time($id, $order)
{
    $sql = "SELECT `date` FROM `comment` WHERE `product_id` =" . $id;
    $sql .=  " ORDER BY `date` " . $order;
    $sql .= " LIMIT 1";
    $data = pdo_query($sql);

    return $data[0]['date'] ?? "";
}

function delete_comment($comment_id)
{
    //if $comment_id is an array, use recursion
    if (is_array($comment_id)) {
        foreach ($comment_id as $id) {
            delete_comment($id);
        }
    } else {
        $sql = "DELETE FROM `comment` WHERE `id` = ?";
        pdo_execute($sql, [$comment_id]);
        redirect('comment');
    }
}
