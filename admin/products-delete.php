<?php

require('../config/function.php');

$paraRestultId = checkParamId('id');

if(is_numeric($paraRestultId)) {
    $productId = validate($paraRestultId);
    $errors = [];

    $product = getById('products', $productId);
    if($product['status'] == 200){
        $productDelete = delete('products', $productId);
        if($productDelete) {
            $deleteImage = "../".$product['data']['image'];
            if(file_exists($deleteImage)){
                unlink($deleteImage);
            }
            redirect('products.php','Product Deleted Successfully');
        }else {
            $errors[] = 'Something Went Wrong';
            if(!empty($errors)){
                redirect('products.php', $errors);
            }
        }
    }else {
        redirect('products.php',$category['message']);
    }

}else {
    $errors[] = 'Something Went Wrong';
    if(!empty($errors)){
        redirect('categories.php', $errors);
    }
}