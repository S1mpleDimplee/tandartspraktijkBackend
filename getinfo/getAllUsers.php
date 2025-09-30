<?php
function getAllUsers($conn) {
    $sql = "SELECT userid, firstname, lastname, email, role FROM users";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo json_encode([
            "success" => false,
            "message" => "Database query failed"
        ]);
        return;
    }

    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if (!$users) {
        echo json_encode([
            "success" => false,
            "message" => "No users found",
            "data" => []
        ]);
        return;
    }

    // Add fullName key for convenience
    foreach ($users as &$user) {
        $user['fullName'] = $user['firstname'] . ' ' . $user['lastname'];
    }

    echo json_encode([
        "success" => true,
        "message" => "All users retrieved successfully",
        "data" => $users
    ]);
}
?>