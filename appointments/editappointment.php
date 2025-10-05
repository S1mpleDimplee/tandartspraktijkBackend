<?php

include_once('../functions/checkIfAppointmentIsAvailable.php');

function editAppointment($data, $conn)
{
    $appointmentId = $data['appointmentId'] ?? null;
    $userid = $data['userid'] ?? null;
    $dentistid = $data['dentistid'] ?? null;
    $date = $data['date'] ?? null;
    $time = $data['time'] ?? null;
    $treatments = $data['treatments'] ?? null;
    $note = $data['note'] ?? null;
    $duration = $data['duration'] ?? null;

    if (empty($appointmentId) || empty($userid) || empty($dentistid) || empty($date) || empty($time) || empty($treatments)) {
        echo json_encode([
            "success" => false,
            "message" => "Alle velden moeten ingevuld zijn"
        ]);
        return;
    }

    if (checkIfAppointmentTimeIsUsed($date, $time, $dentistid, $userid, $conn)) {
        echo json_encode([
            "success" => false,
            "message" => "Deze tijd is al bezet voor de geselecteerde tandarts of patient."
        ]);
        return;
    }

    $sql = "UPDATE appointments SET userid = ?, dentistid = ?, date = ?, time = ?, treatment = ?, note = ?, duration = ? WHERE id = ?";
    $smbt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($smbt, "iissssii", $userid, $dentistid, $date, $time, $treatments, $note, $duration, $appointmentId);
    mysqli_stmt_execute($smbt);

    if (mysqli_stmt_affected_rows($smbt) > 0) {
        echo json_encode([
            "success" => true,
            "message" => "Afspraak succesvol bijgewerkt"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Afspraak kon niet worden bijgewerkt of er zijn geen wijzigingen aangebracht: " . mysqli_error($conn)
        ]);
    }
}