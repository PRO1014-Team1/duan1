<?php
// function get_comment($limit = null, $order = null, $cond = null)
// {
//     $sql = "SELECT * FROM `comment`";
//     if ($order) {
//         $sql .= " ORDER BY `$order` DESC";
//     }
//     if ($cond) {
//         $sql .= " WHERE $cond";
//     }
//     if ($limit) {
//         $sql .= " LIMIT $limit";
//     }
//     $data = pdo_query($sql);

//     return $data;
// }

function get_comment()
{
    $sql = "SELECT * FROM `comment`";
    $data = pdo_query($sql);
    return $data;
}

function sort_comment($comments, $sortBy, $order = 0)
{
    if (!$sortBy) return $comments;
    $col = array_column($comments, $sortBy);
    array_multisort($col, ($order ? SORT_DESC : SORT_ASC), $comments);
    return $comments;
}

function filter_comment($comments, $filterBy, $value)
{
    $result = array_filter($comments, function ($item) use ($filterBy, $value) {
        return ($item[$filterBy] == $value);
    });
    return $result;
}

function get_comment_count($cond = null)
{
    $sql = "SELECT COUNT(*) AS count FROM `comment`";
    if ($cond) {
        $sql .= " WHERE $cond";
    }
    $data = pdo_query($sql);

    return $data[0]['count'];
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
    //if id is an array, use recursion
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
