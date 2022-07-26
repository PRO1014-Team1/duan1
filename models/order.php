<?php

function set_order_info($user_info){
    $errors = validate_user_info($user_info);
    $order_info = [
        'first_name' => $user_info['first_name'],
        'last_name' => $user_info['last_name'],
        'email' => $user_info['email'],
        'phone' => $user_info['phone'],
        'address' => $user_info['address'],
        'city' => $user_info['city'],
        'country' => $user_info['country'],
        'zip_code' => $user_info['zip_code'],
        'note' => $user_info['note'],
        'total_price' => $user_info['total_price'],
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];

    if(empty($errors)){
        $order_info['order_status'] = 'confirmed';
        return $order_info;
    return $order_info;
    }   
}

function validate_user_info($user_info){
    $errors = [];
    //use filter_var to validate the data
    //filter_var returns false if the data is not valid
    //if the data is not valid, add the error message to the $errors array
    //if the data is valid, return the data
    //first_name
    if(!filter_var($user_info['first_name'], FILTER_SANITIZE_STRING)){
        $errors['first_name'] = 'First name is required';
    }
    //last_name
    if(!filter_var($user_info['last_name'], FILTER_SANITIZE_STRING)){
        $errors['last_name'] = 'Last name is required';
    }
    //email
    if(!filter_var($user_info['email'], FILTER_VALIDATE_EMAIL)){
        $errors['email'] = 'Email is required';
    }
    //phone
    if(!filter_var($user_info['phone'], FILTER_SANITIZE_NUMBER_INT)){
        $errors['phone'] = 'Phone is required';
    }
    //address
    if(!filter_var($user_info['address'], FILTER_SANITIZE_STRING)){
        $errors['address'] = 'Address is required';
    }
    //city
    if(!filter_var($user_info['city'], FILTER_SANITIZE_STRING)){
        $errors['city'] = 'City is required';
    }
    //country
    if(!filter_var($user_info['country'], FILTER_SANITIZE_STRING)){
        $errors['country'] = 'Country is required';
    }
    //zip_code
    if(!filter_var($user_info['zip_code'], FILTER_SANITIZE_NUMBER_INT)){
        $errors['zip_code'] = 'Zip code is required';
    }


    // // Kiểm tra ô trống
    // if(empty($user_info['first_name'])){
    //     $errors['first_name'] = 'Vui lòng nhập tên';
    // }
    // if(empty($user_info['last_name'])){
    //     $errors['last_name'] = 'Vui lòng nhập tên đệm';
    // }
    // if(empty($user_info['email'])){
    //     $errors['email'] = 'Vui lòng nhập email';
    // }
    // if(empty($user_info['phone'])){
    //     $errors['phone'] = 'Vui lòng nhập số điện thoại';
    // }
    // if(empty($user_info['address'])){
    //     $errors['address'] = 'Vui lòng nhập địa chỉ';
    // }
    // if(empty($user_info['city'])){
    //     $errors['city'] = 'Vui lòng nhập thành phố';
    // }
    // if(empty($user_info['country'])){
    //     $errors['country'] = 'Vui lòng nhập quốc gia';
    // }
    // if(empty($user_info['zip_code'])){
    //     $errors['zip_code'] = 'Vui lòng nhập mã bưu điện';
    // }

    // // check first name using regex
    // if(!preg_match('/^[a-zA-Z\s]+$/', $user_info['first_name'])){
    //     $errors['first_name'] = 'Tên không hợp lệ';
    // }
    // // check last name using regex
    // if(!preg_match('/^[a-zA-Z\s]+$/', $user_info['last_name'])){
    //     $errors['last_name'] = 'Tên đệm không hợp lệ';
    // }
    // // check email using regex
    // if(!preg_match('/^[a-zA-Z0-9_\.]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/', $user_info['email'])){
    //     $errors['email'] = 'Email không hợp lệ';
    // }
    // // check phone using regex
    // if(!preg_match('/^[0-9]{10,12}$/', $user_info['phone'])){
    //     $errors['phone'] = 'Số điện thoại không hợp lệ';
    // }
    // // check address using regex
    // if(!preg_match('/^[a-zA-Z0-9\s]+$/', $user_info['address'])){
    //     $errors['address'] = 'Địa chỉ không hợp lệ';
    // }
    // // check city using regex
    // if(!preg_match('/^[a-zA-Z\s]+$/', $user_info['city'])){
    //     $errors['city'] = 'Thành phố không hợp lệ';
    // }
    // // check country using regex
    // if(!preg_match('/^[a-zA-Z\s]+$/', $user_info['country'])){
    //     $errors['country'] = 'Quốc gia không hợp lệ';
    // }
    // // check zip code using regex
    // if(!preg_match('/^[0-9]{5,6}$/', $user_info['zip_code'])){
    //     $errors['zip_code'] = 'Mã bưu điện không hợp lệ';
    // }

    return $errors;
}
