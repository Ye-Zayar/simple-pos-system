<?php

require('../config/function.php');

$paraRestultId = checkParamId('id');

if(is_numeric($paraRestultId)) {
    $categoryId = validate($paraRestultId);
    $errors = [];

    $category = getById('categories', $categoryId);
    if($category['status'] == 200){
        $categoryDelete = delete('categories', $categoryId);
        if($categoryDelete) {
            redirect('categories.php','Category Deleted Successfully');
        }else {
            $errors[] = 'Something Went Wrong';
            if(!empty($errors)){
                redirect('categories.php', $errors);
            }
        }
    }else {
        redirect('categories.php',$category['message']);
    }

}else {
    $errors[] = 'Something Went Wrong';
    if(!empty($errors)){
        redirect('categories.php', $errors);
    }
}