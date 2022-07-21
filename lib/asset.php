<?php

function assets($path)
{
    $asset_path = "public/";
    $assets = [
        "css" => $asset_path . "css/" . $path . ".css",
        "js" => $asset_path . "js/" . $path . ".js",
    ];
    $asset_js = "<script src='" . $assets["js"] . "'></script>";
    $asset_css = "<link rel='stylesheet' href='" . $assets["css"] . "'>";

    echo $asset_js . $asset_css;
}
