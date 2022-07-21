<?php

function view($path, $data = [])
{
    extract($data);
    include_once "views/" . $path . ".php";
}

