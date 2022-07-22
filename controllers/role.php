<?php

function deny_access($role){
    if($role == 1){
        alert("Bạn không có quyền truy cập trang này");
        path_not_found();
    }
}

?>