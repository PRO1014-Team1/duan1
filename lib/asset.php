<?php

function assets($path)
{
    if(filter_var($path, FILTER_VALIDATE_URL)){
        echo $path;
        return;
    }
    if(isHTML($path)){
        echo $path;
        return;
    }

    $asset_path = "public/";
    $assets = [
        "css" => $asset_path . "css/" . $path . ".css",
        "js" => $asset_path . "js/" . $path . ".js",
    ];
    $asset_js = "<script src='" . $assets["js"] . "'></script>";
    $asset_css = "<link rel='stylesheet' href='" . $assets["css"] . "'>";

    echo $asset_js . $asset_css;
}

function isHTML($string){
    return $string != strip_tags($string) ? true:false;
   }