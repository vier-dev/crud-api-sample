<?php
require '../config/db.php';

//error message
function error($message)
{

    $data = [
        "statusCode" => 422,
        "message" => $message
    ];

    echo json_encode($data);
    exit();
}

//insert data
function storeData($dataInput)
{

    global $conn;

    $name = mysqli_real_escape_string($conn, $dataInput['name']);
    $email = mysqli_real_escape_string($conn, $dataInput['email']);

    if(empty(trim($name))){
        return error("Name is required");
    }
    elseif(empty(trim($email))){
        return error("Email is required");
    }
    else
    {
        $sql = "INSERT INTO users (`name`, `email`) VALUES ('$name', '$email')";
        $sql_run = mysqli_query($conn, $sql);

        if ($sql_run) {

            $data = [
                "statusCode" => 201,
                "message" => "Data inserted"
            ];
    
            return json_encode($data);
        } else {
            $data = [
                "statusCode" => 500,
                "message" => "Data not found"
            ];
    
            return json_encode($data);
        }
    }
}

//show list
function getList()
{

    global $conn;

    $sql = "SELECT * FROM users";
    $sql_run = mysqli_query($conn, $sql);

    if ($sql_run) {

        if (mysqli_num_rows($sql_run) > 0) {

            $res = mysqli_fetch_all($sql_run, MYSQLI_ASSOC);

            $data = [
                "statusCode" => 200,
                "message" => "Data fetch",
                "data" => $res
            ];

            return json_encode($data);
        } else {
            $data = [
                "statusCode" => 404,
                "message" => "Data not found"
            ];
            return json_encode($data);
        }
    } else {
        $data = [
            "statusCode" => 500,
            "message" => "Server error"
        ];
        return json_encode($data);
    }
}

//fetch single user
function getUser($userParams)
{

    global $conn;

    if ($userParams['id'] == null) {

        return error("Enter User ID: ");
    }

    $userId = mysqli_real_escape_string($conn, $userParams['id']);

    $sql = "SELECT * FROM users WHERE id='$userId' LIMIT 1";
    $sql_run = mysqli_query($conn, $sql);

    if ($sql_run) {

        if(mysqli_num_rows($sql_run) == 1) {

            $res = mysqli_fetch_assoc($sql_run);

            $data = [
                "statusCode" => 200,
                "message" => "Data fetch",
                "data" => $res
            ];
    
            return json_encode($res);

        }
        else
        {
            $data = [
                "statusCode" => 404,
                "message" => "No user found with this ID."
            ];
    
            return json_encode($data);
        }

    } 
    else 
    {
        $data = [
            "statusCode" => 500,
            "message" => "Data not found"
        ];

        return json_encode($data);
    }
}

//update data
function updateData($dataInput, $userParams)
{

    global $conn;

    if(!isset($userParams['id'])){

        return error("ID is not found");
    }
    elseif($userParams['id'] == null)
    {
        return error("Enter user ID");
    }

    $userId = mysqli_real_escape_string($conn, $userParams['id']);

    $name = mysqli_real_escape_string($conn, $dataInput['name']);
    $email = mysqli_real_escape_string($conn, $dataInput['email']);


    if(empty(trim($name))){
        return error("Enter Name");
    }
    elseif(empty(trim($email))){
        return error("Enter Email");
    }
    else
    {
        $sql = "UPDATE users SET name='$name', email='$email' WHERE id='$userId' LIMIT 1";
        $sql_run = mysqli_query($conn, $sql);

        if ($sql_run) {

            $data = [
                "statusCode" => 200,
                "message" => "Data updated"
            ];
    
            return json_encode($data);
        } else {
            $data = [
                "statusCode" => 500,
                "message" => "Data not found"
            ];
    
            return json_encode($data);
        }
    }
}

//delete data
function deleteData($userParams)
{

    global $conn;

    if(!isset($userParams['id'])) {

        return error("ID is not found");
    }
    elseif ($userParams['id'] == null) {

        return error("Enter User Id");
    }

    $userId = mysqli_real_escape_string($conn, $userParams['id']);

    $sql = "DELETE FROM users WHERE id='$userId' LIMIT 1";
    $sql_run = mysqli_query($conn, $sql);

    if($sql_run){
        $data = [
            "statusCode" => 200,
            "message" => "Data is deleted"
        ];

        return json_encode($data);
    }
    else{

        $data = [
            "statusCode" => 404,
            "message" => "User with this ID is not found."
        ];

        return json_encode($data);
    }
}