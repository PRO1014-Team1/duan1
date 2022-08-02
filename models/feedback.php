<?php

function set_feedback($feedback)
{
    $errors = validate_feedback($feedback);
    $feedback = [
        'username' => get_username(),
        'firstname' => $feedback['firstname'],
        'lastname' => $feedback['lastname'],
        'phone' => $feedback['phone'],
        'email' => $feedback['email'],
        'message' => $feedback['message'],
       
    ];
    return $feedback;
}

function validate_feedback($feedback)
{
    $errors = [];

    // Kiểm tra ô trống
    if (empty($feedback['firstname']) || $feedback['firstname'] == '') {
        $errors['firstname'] = 'Vui lòng nhập tên';
    }
    if (empty($feedback['lastname'])) {
        $errors['lastname'] = 'Vui lòng nhập tên đệm';
    }
    if (empty($feedback['email'])) {
        $errors['email'] = 'Vui lòng nhập email';
    }
    if (empty($feedback['phone'])) {
        $errors['phone'] = 'Vui lòng nhập số điện thoại';
    }
    if (empty($feedback['message'])) {
        $errors['massage'] = 'Soạn tin';
    }

    if(!empty($errors)) {
        return $errors;
    }
    // return false if there are special character or number in the name 
    if (!preg_match('/^[^\d\W]+$/u', $feedback['firstname'])) {
        $errors['firstname'] = 'Tên không hợp lệ';
    }
    // check last name using regex
    if (!preg_match('/^[^\d\W]+$/u', $feedback['lastname'])) {
        $errors['lastname'] = 'Tên đệm không hợp lệ';
    }
    //email
    if (!filter_var($feedback['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email không hợp lệ';
    }
    //phone
    if (!filter_var($feedback['phone'], FILTER_SANITIZE_NUMBER_INT)) {
        $errors['phone'] = 'Số điện thoại không hợp lệ';
    }

    return $errors;
}

//Tạo mã order
function generate_id()
{
    $code = 'ORD' . date('YmdHis');
    return $code;
}

function get_user_order($user_id){
    $sql = "SELECT * FROM feedback WHERE `username` = ?";
    $result = pdo_query($sql, [$user_id]);
    return $result;
}

function get_order_detail($id){
    $sql = "SELECT * FROM order_detail WHERE `id` = ?";
    $result = pdo_query($sql, [$id]);
    return $result;
}