<?php
function get_library($library_id, $product_id = null, $type_id = null)
{
    $sql = "SELECT * FROM library WHERE library_id = ?";
    if ($product_id && $type_id) {
        $sql .= " AND product_id = ? AND type_id = ?";
        $result = pdo_query($sql, [$library_id, $product_id, $type_id]);
    } elseif ($product_id) {
        $sql .= " AND product_id = ?";
        $result = pdo_query($sql, [$library_id, $product_id]);
    } else {
        $result = pdo_query($sql, [$library_id]);
    }
    return $result;
}


function set_library($library_id, $product_id, $type_id)
{
    $sql = "INSERT INTO library (library_id, product_id, `type_id`) VALUES (?, ?, ?)";
    return pdo_query($sql, [$library_id, $product_id, $type_id]);
}

function update_library($library_id, $product_id, $bookmarks = [])
{
    $sql = "UPDATE library SET bookmarks = ? WHERE library_id = ? AND product_id = ?";
    return pdo_query($sql, [implode(",", $bookmarks), $library_id, $product_id]);
}
