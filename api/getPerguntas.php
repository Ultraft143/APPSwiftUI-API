<?php

//creating response array
$response = array();

if($_SERVER['REQUEST_METHOD']=='GET'){

    //including the db operation file
    require_once '../includes/dboperations.php';

    $db = new DbOperation();

    $arrayResult = $db->getPerguntas();

    //inserting values 
    if($arrayResult != null){
        //$response['error']=false;
        //$response['message']='Track loaded successfully!';
    }else{
        $response['error']=true;
        $response['message']='Could not get tracks';

        echo json_encode($response);
    }

}else{
    $response['error']=true;
    $response['message']='You are not authorized';

    echo json_encode($response);
}

?>