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

    $queryresult = $db->createUser($email,$name,$password,$admin);
    
    if(($queryresult == 1)){
        $response['error']=false;
        $response['message']='Utilizador adicionado com sucesso';
    }else{
        if($queryresult == "Email already exists"){
            $response['error']=true;
            $response['message']='Email existente';
        }else{
            $response['error']=true;
            $response['message']='Não foi possivel adicionar Utilizador';
        }
    }

}else{
    $response['error']=true;
    $response['message']='You are not authorized';
}

echo json_encode($response);

?>