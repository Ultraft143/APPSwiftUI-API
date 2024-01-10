<?php

//creating response array
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){

    //getting values
    $email = $_POST['user_email'];
    $name = $_POST['user_name'];
    $password = $_POST['user_password'];
    $admin = 0;

    //including the db operation file
    require_once '../includes/dboperations.php';

    $db = new DbOperation();

    //inserting values 
    if($db->createUser($email,$name,$password,$admin)){

        $response['error']=false;
        $response['message']='User added successfully';
    }else{
        $response['error']=true;
        $response['message']='Could not add user';
    }

}else{
    $response['error']=true;
    $response['message']='You are not authorized';
}

echo json_encode($response);

?>