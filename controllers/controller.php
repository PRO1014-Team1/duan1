<?php
require_once "lib/render.php";
require_once "models/hang_hoa.php";

function hang_hoa_index()
{
    $hang_hoa = hang_hoa_all();
    view('hang_hoa_index', ['hang_hoa' => $hang_hoa]);
}
