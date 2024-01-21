<?php

//creating response array
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){

    //getting values
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $idTrack = $_POST['idTrack'];
    $questao = $_POST['pergunta'];

    //including the db operation file
    require_once '../includes/dboperations.php';

    $db = new DbOperation();

    if(($db->createPergunta($nome,$email,$idTrack,$questao))){
        $response['error']=false;
        $response['message']='Pergunta adicionada com sucesso';
    }else{
        $response['error']=true;
        $response['message']='Nao foi possivel registar a pergunta';
    }

}else{
    $response['error']=true;
    $response['message']='You are not authorized';
}

echo json_encode($response);

?>