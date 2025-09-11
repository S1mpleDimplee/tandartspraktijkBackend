<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

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
        break;
    case 'loginUser':
        break;
    default:
        echo json_encode(["success" => false, "message" => "Function not found"]);
        error_log("Function not found: " . $function);
        break;
}

function addUser($data, $conn)
{
    $name = $data['name'] ?? '';
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashedPassword')";

    mysqli_query($conn, $sql);

    echo json_encode([
        "success" => mysqli_affected_rows($conn) > 0,
        "message" => mysqli_affected_rows($conn) > 0 ? "User registered successfully" : "Registration failed",
        "userId" => mysqli_insert_id($conn)
    ]);
}

mysqli_close($connection);
?>