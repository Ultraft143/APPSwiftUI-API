<?php

//creating response array
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){

    //getting values
    $name = $_POST['user_name'];
    $password = $_POST['user_password'];

    //including the db operation file
    require_once '../includes/dboperations.php';

    $db = new DbOperation();
    
    $result = $db->getUser($name,$password);

    //inserting values 
    if($result != null){
        $response['id']=$result;
        $response['error']=false;
        $response['message']='Log in successfully';
    }else{
        $response['error']=true;
        $response['message']='Could not Log in';
    }

}else{
    $response['error']=true;
    $response['message']='You are not authorized';
}

echo json_encode($response);

?>