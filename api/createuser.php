<?php

//creating response array
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
    $admin = 0;

    //getting values
    $email = $_POST['user_email'];
    $name = $_POST['user_name'];
    $password = $_POST['user_password'];
    $admin = $_POST['admin'];

    //including the db operation file
    require_once '../includes/dboperations.php';

    $db = new DbOperation();

    //inserting values 
    if($db->createTeam($email,$name,$password,$admin)){
        $response['error']=false;
        $response['message']='Team added successfully';
    }else{

        $response['error']=true;
        $response['message']='Could not add team';
    }

}else{
    $response['error']=true;
    $response['message']='You are not authorized';
}
echo json_encode($response);

?>