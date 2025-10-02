<?php

function addTreatment($data, $conn)
{
    $userid = $data['userid'] ?? null;
    $treatment_name = $data['treatment'] ?? null;
    $treatment_description = $data['note'] ?? null;

    if (is_null($userid) || $treatment_name == "") {
        echo json_encode([
            "success" => false,
            "message" => "Niet alle vereiste velden zijn ingevuld"
        ]);
        return;
    }

    $sql = "INSERT INTO usertreatments (userid, treatment, note) VALUES ('$userid', '$treatment_name', '$treatment_description')";
    if (mysqli_query($conn, $sql)) {
        echo json_encode([
            "success" => true,
            "message" => "Treatment added successfully"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Error adding treatment: " . mysqli_error($conn)
        ]);
    }
}