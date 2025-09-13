<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include '../register/register.php';

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
    die(json_encode(["success" => false, "message" => "Connection failed"]));
}

$data = json_decode(file_get_contents('php://input'), true);

// Get the function name from the request
$function = $data['function'] ?? '';

// Check which function to call
switch ($function) {
    case 'addUser':
        addUser($data, $connection);
        error_log("Function called: " . $function);
        break;
    case 'loginUser':
        checkLogin($data, $connection);
        break;
    default:
        echo json_encode(["success" => false, "message" => "Function not found"]);
        break;
}
?>