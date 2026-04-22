<?php

use Dom\Mysql;

if(isset($_SESSION['loggedIn'])){
    $errors = [];
    $email = validate($_SESSION['loggedInUser']['email']);

    $query = "SELECT * FROM admins WHERE email='$email' LIMIT 1";
    $result = mysqli_query($con, $query);
    if(mysqli_num_rows($result) == 0) {
        logoutSession();
        $errors[] = 'Access Denied';
        if(!empty($errors)){
            redirect('../login.php', $errors);
        } 
    }else {
        $row = mysqli_fetch_assoc($result);
        if($row['is_ban'] == 1) {
            $errors[] = 'Your account has been banned! Please contact admin.';
            if(!empty($errors)){
                redirect('../login.php', $errors);
            } 
        }
    }

}else{
    $errors[] = 'Login to contine...';
    if(!empty($errors)){
        redirect('../login.php', $errors);
    } 
}