<?php 

require('config/function.php');

if(isset($_POST['loginBtn']) && $_SERVER["REQUEST_METHOD"] === 'POST') {

    $errors = [];
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);

    if($email != '' && $password != '') {
        $query = "SELECT * FROM admins WHERE email='$email' LIMIT 1";
        $result = mysqli_query($con, $query);
        if($result) {
            if(mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                $hashedPassword = $row['password'];
                if(!password_verify($password, $hashedPassword)) {
                    $errors[] = 'Invalid Password';
                    if(!empty($errors)) {
                        redirect('login.php', $errors);
                    }
                }

                if($row['is_ban'] == 1){
                    $errors[] = 'You account has been banned. Contact your Admin.';
                    if(!empty($errors)) {
                        redirect('login.php', $errors);
                    }
                }

                $_SESSION['loggedIn'] = true;
                $_SESSION['loggedInUser'] = [
                    'user_id' => $row['id'],
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'phone' => $row['phone']
                ];

                redirect('admin/index.php', 'Logged In Successfully!');
                
            }else {
                $errors[] = 'Invalid Email Address';
                if(!empty($errors)) {
                    redirect('login.php', $errors);
                }
            }
        }else {
            $errors[] = 'Something Went Wrong!';
            if(!empty($errors)) {
                redirect('login.php', $errors);
            }
        }
    }else {
         $errors[] = 'All fields are mandetory!';
         if(!empty($errors)) {
            redirect('login.php', $errors);
        }
    }
}