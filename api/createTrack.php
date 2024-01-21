<?php

//creating response array
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){

    //getting values
    $nome = $_POST['nome'];
    $texto = $_POST['texto'];
    $titulo = $_POST['titulo'];
    $autores = $_POST['autores'];
    $descricao = $_POST['descricao'];
    $sala = $_POST['sala'];
    $data = $_POST['data'];
    $hora = $_POST['hora'];
    $ficheiro = $_POST['ficheiro'];
    $foto = $_POST['foto'];

    if($ficheiro == null){
        $escolhido = $foto;
    }
    else if($foto == null){
        $escolhido = $ficheiro;
    }else{
        $escolhido = null;
    }
    //including the db operation file
    require_once '../includes/dboperations.php';

    $db = new DbOperation();

    //inserting values 
    if($db->createTrack($nome, $texto, $titulo, $autores, $descricao, $sala, $data, $hora, $escolhido)){
        $response['error']=false;
        $response['message']='Criado com sucesso';
    }else{
        $response['error']=true;
        $response['message']='Ocorreu um erro ao criar a track';
    }

}else{
    $response['error']=true;
    $response['message']='You are not authorized';
}

echo json_encode($response);

?>