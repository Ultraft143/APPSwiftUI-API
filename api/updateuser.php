<?php

//creating response array
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){

    //getting values
    $changeID = $_POST['changeID'];
    $email = $_POST['user_email'];
    $name = $_POST['user_name'];
    $password = $_POST['user_password'];

    //including the db operation file
    require_once '../includes/dboperations.php';

    $db = new DbOperation();

    //inserting values 
    if($db->updateUser($changeID, $email, $name, $password)){
        $response['error']=false;
        $response['message']='Update feito com sucesso';
    }else{
        $response['error']=true;
        $response['message']='Ocorreu um erro no Update';
    }

}else{
    $response['error']=true;
    $response['message']='You are not authorized';
}

echo json_encode($response);

?>