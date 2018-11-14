<?php
include 'database/connection.php';

function send_response($reponseArray, $responseCode){
    header('Content-type: application/json');
    http_response_code($responseCode);
    echo json_encode($reponseArray);
    
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && !isset($_GET['key'])){
    //This part is for fetching All Valid CD KEY    
    $result = mysqli_query($con,"SELECT * FROM cd_keys WHERE is_valid is NULL");
    $res = mysqli_fetch_all($result,MYSQLI_ASSOC);
    send_response([
        'count' => count($res),
        'data' => $res
    ], 200);

} else if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    //This part is creating new CD KEY
    $json = file_get_contents('php://input');
    $data = json_decode($json,false);
    mysqli_query($con,"INSERT INTO cd_keys (id,cd_key,is_valid) VALUES (null,'$data->cd_key',null)");
    $result = mysqli_affected_rows($con);
    if($result === 1){
        send_response([
            'data' => 'New CD KEY created with key '.$data->cd_key
        ], 201);
    }else{
        send_response([
            'data' => 'Failed to create CD KEY'
        ], 422);
    }

}else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['key'])){
    //This part is for validateing the CD KEY
    $result = mysqli_query($con,"SELECT * FROM cd_keys WHERE cd_key = '" .$_GET['key']. "' AND is_valid IS NULL");
    $res = mysqli_fetch_all($result,MYSQLI_ASSOC);
    if(count($res) == 1){
        $query = "UPDATE cd_keys SET is_valid = '" .date("Y/m/d"). "' WHERE cd_key = '" .$_GET['key']. "'";
        $result = mysqli_query($con,$query);
        if(count($result) == 1){
            send_response([
                'data' => 'Thank You. Your key is validated successfully'
            ], 200);
        }else{
            send_response([
                'data' => 'Internal Server Error'
            ], 500);
        }
    }else{
        send_response([
            'data' => $_GET['key'].' key is not a valid KEY'
        ], 404);
    }

}else{
    http_response_code(404);
    echo json_encode(['message' => 'No End Point Found']);
}

mysqli_close($con);
