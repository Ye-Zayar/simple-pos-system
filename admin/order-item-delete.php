<?php 

require('../config/function.php');

$paramResult = checkParamId('index');
$errors = [];
if(is_numeric($paramResult)){
    $indexValue = validate($paramResult);
    if(isset($_SESSION['productItems']) && isset($_SESSION['productItemIds'])){
        unset($_SESSION['productItems'][$indexValue]);
        unset($_SESSION['productItemIds'][$indexValue]);
        redirect('order-create.php', 'Item Removed');
    }else {
        $errors[] = 'There is no item.';
        if(!empty($errors)){
            redirect('order-create.php', $errors);
        }
    }
}else {
    $errors[] = 'Param not numeric';
    if(!empty($errors)){
        redirect('order-create.php', $errors);
    }
}