<?php

require('../config/function.php');

$paraRestultId = checkParamId('id');

if(is_numeric($paraRestultId)) {
    $adminId = validate($paraRestultId);
    $errors = [];
    $admin = getById('admins', $adminId);
    if($admin['status'] == 200){
        $adminDeletes = delete('admins', $adminId);
        if($adminDeletes) {
            redirect('admin.php','Admin Deleted Successfully');
        }else {
            $errors[] = 'Something Went Wrong';
            if(!empty($erros)){
                redirect('admin.php',$errors);
            }
        }
    }else {
     redirect('admin.php',$admin['message']);
    }

}else {
    $errors[] = 'Something Went Wrong';
    if(!empty($erros)){
        redirect('admin.php',$errors);
    }
}