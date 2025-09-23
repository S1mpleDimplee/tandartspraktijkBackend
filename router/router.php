<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Include other backend functions
include '../register/register.php';
include '../userdata/getUserData.php';
include '../userdata/updateUserData.php';
include '../tandarts/appointmentData.php';

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Database connection
$connection = mysqli_connect("localhost", "root", "", "tandartspraktijk");
if (!$connection) {
    error_log("Connection failed: " . mysqli_connect_error());
    die(json_encode(["success" => false, "message" => "Connection with DB Failed"]));
}

// Read POST data
$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    error_log("Invalid JSON input");
    die(json_encode(["success" => false, "message" => "Invalid JSON input"]));
}

// Get function name
$function = $data['function'] ?? '';
$data = $data['data'] ?? [];

// Router switch
switch ($function) {
    case 'addUser':
        addUser($data, $connection);
        break;
    case 'loginUser':
        checkLogin($data, $connection);
        break;
    case 'fetchUserData':
        getUserData($data, $connection);
        break;
    case 'updateUserData':
        UpdateUserData($data, $connection);
        break;
    case 'checkAppointments':
        $stats = checkAppointments($connection);
        echo json_encode([
            "success" => true,
            "message" => "Appointments counted",
            "data" => $stats
        ]);
        break;
    default:
        echo json_encode(["success" => false, "message" => "Function not found"]);
        break;
}
?>
