<?php
function get_customer($limit = null, $cond = null, $order = null)
{
    $sql = "SELECT * FROM `users`";

    if ($cond) {
        $sql .=  " WHERE $cond";
    }
    if ($order) {
        $sql .= " ORDER BY `$order` DESC";
    }
    if ($limit) {
        $sql .= " LIMIT $limit";
    }
    $data = pdo_query($sql);

    return $data;
}

function delete_customer($username)
{

    //if id is an array, use recursion
    if (is_array($username)) {
        foreach ($username as $id) {
            delete_product($id);
        }
    } else {
        $sql = "DELETE FROM `users` WHERE `username` = ?";
        pdo_execute($sql, [$username]);
        redirect('customer');
    }
}
