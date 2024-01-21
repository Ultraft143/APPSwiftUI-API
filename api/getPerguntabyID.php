<?php

//creating response array
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){

    //including the db operation file
    require_once '../includes/dboperations.php';

    $db = new DbOperation();

    $ID = $_POST['id'];

    $arrayResult = $db->getPerguntabyID($ID);

    //inserting values 
    if($arrayResult != null){
        //$response['error']=false;
        //$response['message']='Track loaded successfully!';
        echo json_encode($arrayResult);
    }else{
        $response['error']=true;
        $response['message']='Could not get track';

        echo json_encode($response);
    }

}else{
    $response['error']=true;
    $response['message']='You are not authorized';

    echo json_encode($response);
}

?>