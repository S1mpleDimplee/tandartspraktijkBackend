<?php

function deleteAppointment($data, $conn)
{
    $appointmentId = $data['appointmentId'] ?? null;

    if (empty($appointmentId)) {
        echo json_encode([
            "success" => false,
            "message" => "Afspraak niet gevonden"
        ]);
        return;
    }

    $sql = "DELETE FROM appointments WHERE id = ?";
    $smbt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($smbt, "i", $appointmentId);
    mysqli_stmt_execute($smbt);

    if (mysqli_stmt_affected_rows($smbt) > 0) {
        echo json_encode([
            "success" => true,
            "message" => "Afspraak succesvol verwijderd"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Afspraak kon niet worden verwijderd: " . mysqli_error($conn)
        ]);
    }
}