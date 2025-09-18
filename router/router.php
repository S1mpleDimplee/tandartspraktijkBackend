<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include '../register/register.php';
include '../userdata/getUserData.php';

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}


// Database connection
$connection = mysqli_connect("localhost", "root", "", "tandartspraktijk");

// Check if there us connection with database ifnot log error
if (!$connection) {
    error_log("Connection failed: " . mysqli_connect_error());
    die(json_encode(["success" => false, "message" => "Connection with DB Failed"]));
}

$data = json_decode(file_get_contents('php://input'), true);
    
if (!$data) {
    error_log("Invalid JSON input");
    die(json_encode(["success" => false, "message" => "Invalid JSON input"]));
}

// Get the function name from the request
$function = $data['function'] ?? '';

$data = $data['data'] ?? [];

// Check which function to call
switch ($function) {
    case 'addUser':
        addUser($data, $connection);
        break;
    case 'loginUser':
        checkLogin($data, $connection);
        break;
    case 'fetchUserData':
        getUserData($data, $connection);
    default:
        echo json_encode(["success" => false, "message" => "Function not found"]);
        break;
}
?>