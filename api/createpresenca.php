<?php

//creating response array
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){

    //getting values
    $nome = $_POST['nome'];
    $empresa = $_POST['empresa'];
    $email = $_POST['email'];
    $contacto = $_POST['contacto'];
    $data = $_POST['data'];
    $idTrack = $_POST['idTrack'];

    //including the db operation file
    require_once '../includes/dboperations.php';

    $db = new DbOperation();

    $queryresult = $db->createPresenca($nome,$empresa,$email,$contacto,$data,$idTrack);
    
    if(($queryresult)){
        $response['error']=false;
        $response['message']='Presenca adicionada com sucesso';
    }else{
            $response['error']=true;
            $response['message']='Não foi possivel registar a presenca';
    }

}else{
    $response['error']=true;
    $response['message']='You are not authorized';
}

echo json_encode($response);

?>