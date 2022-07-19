<?php
require_once "database.php";

function hang_hoa_all()
{
    $sql = "SELECT * FROM hang_hoa";
    return get_data_all($sql);
}
