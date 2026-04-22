<?php 

session_start();
require 'db.php';

// Input field validation
function validate($inputData){
    global $con;
    $validateData = mysqli_real_escape_string($con, $inputData);
    return trim($validateData);
}

// Redirect from 1 page to another page with the message (status)
function redirect($url, $status) {
    //$_SESSION['status'] = $status;
    if(is_array($status)){
        $_SESSION['errors'] = $status;
    }else {
        $_SESSION['status'] = $status;
    }
    header('Location: '.$url);
    exit(0);
}

// Display messages or status after any process.
function alertMessage(){
    if(isset($_SESSION['status'])){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <h6>'.$_SESSION['status'].'</h6>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        unset($_SESSION['status']);
    }
}
// Display messages or status after any process.
function alertErrorMessage(){
    if(isset($_SESSION['errors'])){
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
        foreach($_SESSION['errors'] as $error){
            echo '<h6>'.$error.'</h6>';
        }
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>';
        unset($_SESSION['errors']);
    }
}



// Insert record 
function insert($tableName, $data){
    global $con;

    $table = validate($tableName);

    $columns = array_keys($data);
    $values = array_values($data);

    $finalColumn = implode(',', $columns);
    $finalValues = "'".implode("', '", $values)."'";

    $query = "INSERT INTO $table ($finalColumn) VALUES ($finalValues)";
    $result = mysqli_query($con, $query);
    return $result;
}

//Update data 
function update($tableName, $id, $data) {
    global $con;

    $table = validate($tableName);
    $id = validate($id);

    $updateDataString = "";

    foreach($data as $column => $value) {
        $updateDataString .= $column.'='."'$value',";
    }
    $finalUpdateData = substr(trim($updateDataString),0,-1);

    $query = "UPDATE $table SET $finalUpdateData WHERE id='$id'";
    $result = mysqli_query($con, $query);
    return $result;
}

function getAll($tableName, $status = NULL) {
    global $con;

    $table = validate($tableName);
    $status = validate($status);

    if($status == 'status'){
        $query = "SELECT * FROM $table WHERE $status='0'";
    }
    else {
         $query = "SELECT * FROM $table";
    }
    return mysqli_query($con, $query);
}

function getById($tableName, $id) {
    global $con;

    $table = validate($tableName);
    $id = validate($id);

    $query = "SELECT * FROM $table WHERE id='$id' LIMIT 1";
    $result = mysqli_query($con, $query);

    if($result) {

        if(mysqli_num_rows($result) == 1){
            $row = mysqli_fetch_assoc($result);
             $response = [
                'status' => 200,
                'data' => $row,
                'message' => 'Record Found!'
            ];
            return $response;

        }else {
            $response = [
            'status' => 404,
            'message' => 'NO Data Found!'
            ];
            return $response;
        }

    }
    else {
        $response = [
            'status' => 500,
            'message' => 'Something Went Wrong!'
        ];
        return $response;
    }
}


// Delete data
function delete($tableName, $id) {
    global $con;

    $table = validate($tableName);
    $id = validate($id);

    $query = "DELETE FROM $table WHERE id='$id' LIMIT 1";
    $result = mysqli_query($con, $query);
    return $result;
}

function checkParamId($type){
    if(isset($_GET[$type])){
        if($_GET[$type] != ''){
            return $_GET[$type];
        }else {
            return '<h5>No Id Found</h5>';
        }
    }else {
        return '<h5>No Id Given!</h5>';
    }
}

function logoutSession() {
    unset($_SESSION['loggedIn']);
    unset($_SESSION['loggedInUser']);
    $_SESSION['logoutUser'] = true;
}

function jsonResponse($status,$status_type,$message) {
    $response = [
            'status' => $status,
            'message' => $message,
            'status_type' =>$status_type
        ];
        echo json_encode($response);
        return;
}

function getCount($tableName) {
    global $con;

    $table = validate($tableName);
    $query = "SELECT * FROM $table";
    $query_run = mysqli_query($con, $query);
    if($query_run) {
        $totalCount = mysqli_num_rows($query_run);
        return $totalCount;
    }else {
        return 'Something Went Wrong!';
    }
}