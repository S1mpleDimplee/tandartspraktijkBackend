<?php

function createAppointment($data, $conn)
{
    $userid = $data['userid'] ?? null;
    $dentistid = $data['dentistid'] ?? null;
    $treatments = $data['treatments'] ?? null;
    $note = $data['note'] ?? null;

    $sql = "INSERT INTO appointments (userid, dentistid, treatment, note) VALUES ('$userid', '$dentistid', '$treatments', '$note')";

    if (mysqli_query($conn, $sql)) {
        echo json_encode([
            "success" => true,
            "message" => "Appointment created successfully"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Failed to create appointment"
        ]);
    }
}