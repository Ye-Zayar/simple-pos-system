<?php 

include('../config/function.php');

if(isset($_POST['saveAdmin']) && $_SERVER["REQUEST_METHOD"] === 'POST') {
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $phone = validate($_POST['phone']);
    $is_ban = validate($_POST['is_ban']) == true ? 1:0;

   
    if($name != '' && $email != '' && $password != '')
    {
        $emailCheck = mysqli_query($con, "SELECT * FROM admins WHERE email='$email'");
        if($emailCheck) {
            if(mysqli_num_rows($emailCheck) > 0) {
                redirect('admin-create.php', 'Email Already used by another user.');
            }
        }

        $bcrypt_password = password_hash($password, PASSWORD_BCRYPT);

        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $bcrypt_password,
            'phone' => $phone,
            'is_ban' => $is_ban,
        ];

        $result = insert('admins', $data);
        if($result) {
            redirect('admin.php', 'Admin Created Successfully!');
        }else {
            redirect('admin-create.php', 'Insert data is failed!');
        }

    }else {
        redirect('admins-create.php', 'Please fill required fields.');
    }

}

if(isset($_POST['updateAdmin']) && $_SERVER["REQUEST_METHOD"] === 'POST') {
    $adminId = validate($_POST['adminId']);
    $adminData = getById('admins', $adminId);
    if($adminData['status'] != 200) {
        redirect('admins-edit.php?id='.$adminId, 'Please fill required fields.');
    }

    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $phone = validate($_POST['phone']);
    $is_ban = validate($_POST['is_ban']) == true ? 1:0;

    $emailCheckQuery = "SELECT * FROM admins WHERE email='$email' AND id!='$adminId'";
    $checkResult = mysqli_query($con, $emailCheckQuery);
    if($checkResult){
        if(mysqli_num_rows($checkResult) > 0) {
            redirect('admins-edit.php?id='.$adminId, 'Email already used by another user');
        }
    }

    if($password != '') {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    }else {
        $hashedPassword = $adminData['data']['password'];
    }
   
    if($name != '' && $email != '')
    {
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword,
            'phone' => $phone,
            'is_ban' => $is_ban,
        ];

        $result = update('admins', $adminId, $data);
        if($result) {
            redirect('admin.php', 'Admin Updated Successfully!');
        }else {
            redirect('admins-edit.php?id='.$adminId, 'Update data is failed!');
        }

    }else {
        redirect('admins-create.php', 'Please fill required fields.');
    }
}

if(isset($_POST['saveCategory']) && $_SERVER["REQUEST_METHOD"] === 'POST') {
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $status = isset($_POST['status']) == true ? 1:0;

    $errors = [];
    $data = [
            'name' => $name,
            'description' => $description,
            'status' => $status,
        ];

        $result = insert('categories', $data);
        if($result) {
            redirect('categories.php', 'Category Created Successfully!');
        }else {
            $errors[] = 'Create Category is failed!!';
            if(!empty($errors)){
                redirect('categories-create.php', $errors);
            }
        }
}

if(isset($_POST['updateCategory']) && $_SERVER["REQUEST_METHOD"] === 'POST') {
    $categoryId = validate($_POST['categoryId']);
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $status = isset($_POST['status']) == true ? 1:0;

    $errors = [];
    $data = [
            'name' => $name,
            'description' => $description,
            'status' => $status,
        ];

        $result = update('categories', $categoryId, $data);
        if($result) {
            redirect('categories.php', 'Category Updated Successfully!');
        }else {
            $errors[] = 'Update Category is failed!!';
            if(!empty($errors)){
                redirect('categories-create.php', $errors);
            }
        }
}

if(isset($_POST['saveProduct']) && $_SERVER["REQUEST_METHOD"] === 'POST') {
    

    $category_id = validate($_POST['category_id']);
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $price = validate($_POST['price']);
    $quantity = validate($_POST['quantity']);
    $status = isset($_POST['status']) == true ? 1:0;

    if($_FILES['image']['size'] > 0) {
        $path = "../assets/uploads/products";
        $image_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = time().'.'.$image_ext;
        move_uploaded_file($_FILES['image']['tmp_name'], $path."/".$filename);

        $finalImage = "assets/uploads/products/".$filename;
    }else {
        $finalImage = '';
    }

    $errors = [];
    $data = [
            'category_id' => $category_id,
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'quantity' => $quantity,
            'image' => $finalImage,
            'status' => $status,
        ];

        $result = insert('products', $data);
        if($result) {
            redirect('products.php', 'Product Created Successfully!');
        }else {
            $errors[] = 'Create Product is failed!!';
            if(!empty($errors)){
                redirect('products-create.php', $errors);
            }
        }
}

if(isset($_POST['UpdateProduct']) && $_SERVER["REQUEST_METHOD"] === 'POST'){
    $product_id = validate($_POST['product_id']);
    $errors = [];
    $productData = getById('products', $product_id);
    if(!$productData) {
        $errors[] = 'No such product found!';
        if(!empty($errors)){
            redirect('products.php', $errors);
        }
    }

    $category_id = validate($_POST['category_id']);
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $price = validate($_POST['price']);
    $quantity = validate($_POST['quantity']);
    $status = isset($_POST['status']) == true ? 1:0;

    if($_FILES['image']['size'] > 0) {
        $path = "../assets/uploads/products";
        $image_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = time().'.'.$image_ext;
        move_uploaded_file($_FILES['image']['tmp_name'], $path."/".$filename);

        $finalImage = "assets/uploads/products/".$filename;

        $deleteImage = "../".$productDAta['data']['image'];
        if(file_exists($deleteImage)){
            unlink($deleteImage);
        }
    }else {
        $finalImage = $productDAta['data']['image'];
    }

    $errors = [];
    $data = [
            'category_id' => $category_id,
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'quantity' => $quantity,
            'image' => $finalImage,
            'status' => $status,
        ];

        $result = update('products', $product_id, $data);
        if($result) {
            redirect('products.php', 'Product Updated Successfully!');
        }else {
            $errors[] = 'Create Product is failed!!';
            if(!empty($errors)){
                redirect('products-create.php', $errors);
            }
        }
}

if(isset($_POST['saveCustomer']) &&  $_SERVER["REQUEST_METHOD"] === 'POST') {
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);
    $status = isset($_POST['status']) ? 1:0;

    $errors = [];
    if($name != '') {
        $emailCheck = mysqli_query($con, "SELECT * FROM customers WHERE email='$email'");
        if($emailCheck){
            if(mysqli_num_rows($emailCheck) > 0) {
                $errors[] = 'Email already used by another user.';
                if(!empty($errors)) {
                    redirect('customers.php', $errors);
                }
            }
        }

        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'status' => $status,
        ];

        $result = insert('customers', $data);
        if($result) {
            redirect('customers.php', 'Customer Created Successfully!');
        }else {
            $errors[] = 'Something Went Wrong';
        if(!empty($errors)) {
            redirect('customers.php', $errors);
        }
        }

    }else {
        $errors[] = 'Please fill required fields';
        if(!empty($errors)) {
            redirect('customers.php', $errors);
        }
    }
}

if(isset($_POST['updateCustomer']) &&  $_SERVER["REQUEST_METHOD"] === 'POST') {
    $customerId = validate($_POST['customerId']);
    
    
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);
    $status = isset($_POST['status']) ? 1:0;

    $errors = [];
    if($name != '') {
        $emailCheck = mysqli_query($con, "SELECT * FROM customers WHERE email='$email' AND id!='$customerId'");
        if(mysqli_num_rows($emailCheck) > 0){
            $errors[] = 'Email already used by another user.';
            if(!empty($errors)) {
                redirect('customers-edit.php?id='.$customerId, $errors);
            }
        }
     
        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'status' => $status,
        ];

        $result = update('customers',$customerId, $data);
        if($result) {
            redirect('customers.php', 'Customer Updated Successfully!');
        }else {
            $errors[] = 'Something Went Wrong';
        if(!empty($errors)) {
            redirect('customers.php', $errors);
        }
        }

    }else {
        $errors[] = 'Please fill required fields';
        if(!empty($errors)) {
            redirect('customers-edit.php?id='.$customerId, $errors);
        }
    }
}