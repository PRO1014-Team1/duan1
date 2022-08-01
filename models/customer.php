<?php
function get_customer($target = "*", $limit = null, $cond = null, $order = null)
{
    $sql = "SELECT $target FROM `users`";

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

function get_customer_by_date($start = false, $end = false)
{
    if (!$end) {
        $end = date('Y-m-t');
    }
    if (!$start) {
        return get_customer();
    } else {
        $sql = "SELECT * FROM `users` WHERE created_date BETWEEN ? AND ?";
        $result = pdo_query($sql, [$start, $end]);
    }
    return $result;
}

function get_customer_range($order_by = "week")
{
    echo $order_by;
    $prev_order = [];
    $cur_order = [];
    switch ($order_by) {
        case 'week':
            $prev_order = get_customer_by_date(date('Y-m-d', strtotime('-1 week')), date('Y-m-d', strtotime('-1 day')));
            $cur_order = get_customer_by_date(date('Y-m-d', strtotime('-1 day')), date('Y-m-d'));
            break;
        case 'month':
            $cur_order = get_customer_by_date(date('Y-m-01'));
            $prev_order = get_customer_by_date(date('Y-m-01', strtotime('-1 month')), date('Y-m-t', strtotime('-1 month')));
            break;
        case 'year':
            $cur_order = get_customer_by_date(date('Y-01-01'), date('Y-12-31'));
            $prev_order = get_customer_by_date(date('Y-01-01', strtotime('-1 year')), date('Y-12-31', strtotime('-1 year')));
            break;
        case 'all':
            $cur_order = get_customer_by_date();
            $prev_order = get_customer_by_date();
            break;
    }
    return [$prev_order, $cur_order];
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

//get only 1 column from table
function get_column($table, $column)
{
    $sql = "SELECT `$column` FROM `$table`";
    $data = pdo_query($sql);
    return $data;
}
