<?php

//creating response array
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){

    //getting values
    $ID = $_POST['id'];
    $nome = $_POST['nome'];
    $texto = $_POST['texto'];
    $titulo = $_POST['titulo'];
    $autores = $_POST['autores'];
    $descricao = $_POST['descricao'];
    $sala = $_POST['sala'];
    $data = $_POST['data'];
    $hora = $_POST['hora'];

    //including the db operation file
    require_once '../includes/dboperations.php';

    $db = new DbOperation();

    //inserting values 
    if($db->updateTrack($ID, $nome, $texto, $titulo, $autores, $descricao, $sala, $data, $hora)){
        $response['error']=false;
        $response['message']='Update com sucesso';
    }else{
        $response['error']=true;
        $response['message']='Ocorreu um erro ao dar update a track';
    }

}else{
    $response['error']=true;
    $response['message']='You are not authorized';
}

echo json_encode($response);

?>