<?php

function updateUserRole($data, $conn)
{
    $userid = $data['userid'] ?? null;
    $newRole = $data['role'] ?? 0;
    $rolenames = ['patient', 'tandarts', 'assistente', 'manager'];

    if (is_null($userid) || is_null($newRole)) {
        echo json_encode([
            "success" => false,
            "message" => "Niet alle vereiste velden zijn ingevuld"
        ]);
        return;
    }

    $getPreviousRole = "SELECT role FROM users WHERE userid='$userid'";
    if ($result = mysqli_query($conn, $getPreviousRole)) {
        $user = mysqli_fetch_assoc($result);
        $previousRole = $user['role'] ?? null;
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Er is een fout opgetreden om de tandarts om te zetten naar een andere rol: " . mysqli_error($conn)
        ]);
        return;
    }

    $sql = "UPDATE users SET role='$newRole' WHERE userid='$userid'";

    if (mysqli_query($conn, $sql)) {

        if ($previousRole === "1") {
            $deleteAppointmentsSql = "DELETE FROM appointments WHERE dentistid='$userid' AND date >= CURDATE()";

            mysqli_query($conn, $deleteAppointmentsSql);

            echo json_encode([
                "success" => true,
                "message" => "Tandarts is nu een " . $rolenames[$newRole]
            ]);
            return;
        }

        echo json_encode([
            "success" => true,
            "message" => "gebruiker is nu een " . $rolenames[$newRole]
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Fout bij het bijwerken van de gebruikersrol: " . mysqli_error($conn)
        ]);
    }
}