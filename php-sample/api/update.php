<?php
error_reporting(0);

header("Content-Type: application/json");
header("Access-Control-Allow-Method: PUT");

include ('backend-function.php');

$request = $_SERVER['REQUEST_METHOD'];

if($request == "PUT") {

    $dataInput = json_decode(file_get_contents("php://input"), true);

    if(empty($dataInput)){

        $updateData = updateData($_POST, $_GET);
    }
    else
    {
        $updateData = updateData($dataInput, $_GET);
    }

    echo $updateData;

   
}
else {

    $data = [
        "statusCode" => 405,
        "message" => $request. " Method is not allowed"
    ];

    echo json_encode($data);
}
?>