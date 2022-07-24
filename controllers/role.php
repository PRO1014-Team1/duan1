<?php

function deny_access($role = 1){
    if($role != 2){
        alert("Bạn không có quyền truy cập trang này");
        redirect("/");
        return true;
    }
    return false;
}
