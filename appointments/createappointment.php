<?php

include_once('../functions/checkIfAppointmentIsAvailable.php');
function createAppointment($data, $conn)
{
    $userid = $data['userid'] ?? null;
    $dentistid = $data['dentistid'] ?? null;
    $date = $data['date'] ?? null;
    $time = $data['time'] ?? null;
    $treatments = $data['treatments'] ?? null;
    $note = $data['note'] ?? null;
    $duration = $data['duration'] ?? null;


    if (checkIfAppointmentTimeIsUsed($date, $time, $dentistid, $userid, $conn)) {
        echo json_encode([
            "success" => false,
            "message" => "Deze tijd is al bezet voor de geselecteerde tandarts of patient."
        ]);
        return;
    }

    if (empty($userid) || empty($dentistid) || empty($date) || empty($time) || empty($treatments)) {
        echo json_encode([
            "success" => false,
            "message" => "Alle velden moeten ingevuld zijn"
        ]);
        return;
    }

    $sql = "INSERT INTO appointments (userid, dentistid, date, time, treatment, note, duration) VALUES 
    ('$userid', '$dentistid', '$date', '$time', '$treatments', '$note', '$duration')";

    if (mysqli_query($conn, $sql)) {
        echo json_encode([
            "success" => true,
            "message" => "Afspraak succesvol aangemaakt"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Afspraak kon niet worden aangemaakt: " . mysqli_error($conn)
        ]);
    }
}