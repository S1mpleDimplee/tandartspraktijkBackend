<?php

function getCurrentDentistName($userid, $conn)
{
    // Use prepared statements to prevent SQL injection
    $sql = "SELECT CONCAT(d.firstname, ' ', d.lastname) AS name 
            FROM users u 
            JOIN users d ON u.currentdentistid = d.userid 
            WHERE u.userid = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userid); // Bind the parameter as a string
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        return json_encode([
            "success" => true,
            "message" => "Huidige tandarts succesvol opgehaald",
            "data" => $user['name']
        ]);
    } else {
        return json_encode([
            "success" => false,
            "message" => "Geen tandarts gevonden",
            "data" => null
        ]);
    }
}
