<?php
function getUserData($data, $conn)
{
    $userid = $data ?? null;

    if (is_null($userid)) {
        echo json_encode([
            "success" => false,
            "message" => "Userid niet gevonden"
        ]);
        return;
    }

    $sql = "SELECT * FROM users WHERE userid='$userid'";

    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        echo json_encode([
            "isSuccess" => true,
            "data" => $user
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Geen gebruiker gevonden"
        ]);
    }
}
?>