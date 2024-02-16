<?php
error_reporting(0);

header("Content-Type: application/json");
header("Access-Control-Allow-Method: POST");

include ('backend-function.php');

$request = $_SERVER['REQUEST_METHOD'];

if( $request == 'POST') {

    $dataInput = json_decode(file_get_contents("php://input"), true);

    if(empty($dataInput)){

        $storeData = storeData($_POST);
    }
    else
    {
        $storeData = storeData($dataInput);
    }

    echo $storeData;

   
}
else {

    $data = [
        "statusCode" => 405,
        "message" => $request. " Method is not allowed"
    ];

    echo json_encode($data);
}
?>