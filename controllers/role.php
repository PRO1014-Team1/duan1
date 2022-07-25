<?php

function deny_access($role = 0){
    if($role != 1){
        alert("Bạn không có quyền truy cập trang này");
        redirect("/");
        return true;
    }
    return false;
}
