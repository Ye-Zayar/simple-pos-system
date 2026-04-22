<?php

require('../config/function.php');

$paraRestultId = checkParamId('id');

if(is_numeric($paraRestultId)) {
    $customerId = validate($paraRestultId);
    $errors = [];

    $customer = getById('customers', $customerId);
    if($customer['status'] == 200){
        $customerDelete = delete('customers', $customerId);
        if($customerDelete) {
            redirect('customers.php','Customer Deleted Successfully');
        }else {
            $errors[] = 'Something Went Wrong';
            if(!empty($errors)){
                redirect('customers.php', $errors);
            }
        }
    }else {
        redirect('customers.php',$customer['message']);
    }

}else {
    $errors[] = 'Something Went Wrong';
    if(!empty($errors)){
        redirect('customers.php', $errors);
    }
}