<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Include other backend functions
include '../register/register.php';
include '../userdata/getUserData.php';
include '../userdata/getAllUserData.php';
include '../userdata/updateUserData.php';
include '../getinfo/getcurrentdentist.php';
include '../getinfo/getalldentists.php';
include '../getinfo/getallpatients.php';
include '../userdata/updatecurrentdentist.php';
include '../Treatments/getalltreatments.php';
include '../appointments/createappointment.php';
include '../tandarts/getAppointmentsForWeek.php';
include '../tandarts/appointmentData.php';
include '../Treatments/addtreatment.php';
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
$function = strtolower($data['function'] ?? '');
$data = $data['data'] ?? [];

// Router switch
switch ($function) {
    // register and login functions
    case 'adduser':
        addUser($data, $connection);
        break;
    case 'loginuser':
        checkLogin($data, $connection);
        break;
    // user data functions
    case 'fetchuserdata':
        getUserData($data, $connection);
        break;
    case 'fetchalluserdata':
        getAllUserData($data, $connection);
        break;
    case 'updateuserdata':
        UpdateUserData($data, $connection);
        break;
    case 'getappointmentsdatapatient':
        getAppointmentsDataPatient($data['userid'] ?? '', $connection);
        break;
    // get functions
    case 'getcurrentdentist':
        getCurrentDentistName($data['userid'] ?? '', $connection);
        break;
    case 'getalldentists':
        getAllDentists($connection);
        break;
    case 'getallpatients':
        getAllPatients($connection);
        break;
    case 'createappointment':
        createAppointment($data, $connection);
        break;
    case 'getappointmentsforweek':
        getAppointmentsForWeek($data['userid'] ?? null, $data['week'] ?? null, $data['year'] ?? null, $connection);
        break;
    case 'getalltreatments':
        getAllTreatments($connection);
        break;
    case 'updatecurrentdentist':
        updatecurrentdentist($data['userid'] ?? '', $data['dentistid'] ?? null, $connection);
        break;
    case 'checkappointments':
        $stats = checkAppointments($connection);
        echo json_encode([
            "success" => true,
            "message" => "Appointments counted",
            "data" => $stats
        ]);
        break;

    case 'addtreatment':
        addTreatment($data, $connection);
        break;
    case 'updatetreatment':
        break;
    case 'deletetreatment':
        break;
    default:
        echo json_encode(["success" => false, "message" => "Functie niet gevonden"]);
        break;
}
