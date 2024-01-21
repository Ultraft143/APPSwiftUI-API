<?php

//creating response array
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){

    //getting values
    $nomeTarck = $_POST['nome'];
    $textoTrack = $_POST['texto'];

    //including the db operation file
    require_once '../includes/dboperations.php';

    $db = new DbOperation();
    
    $query_result = $db->deleteTrack($nomeTarck, $textoTrack);

    if($query_result){
        $response['error']=false;
        $response['message']='Track foi apagada com sucesso';
    }else{
        $response['error']=true;
        $response['message']='Nao foi possivel apagar a Track';
    }

}else{
    $response['error']=true;
    $response['message']='You are not authorized';
}

echo json_encode($response);

?>