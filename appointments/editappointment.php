<?php

include_once('../functions/checkIfAppointmentIsAvailable.php');
include_once('../functions/sendEmail.php');

function editAppointment($data, $conn)
{
    $appointmentId = $data['appointmentId'] ?? null;
    $userid = $data['userid'] ?? "test";
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

    $query = "UPDATE appointments SET userid = '$userid', dentistid = '$dentistid', date = '$date', time = '$time', treatment = '$treatments', note = '$note', duration = '$duration' WHERE id = '$appointmentId'";
    if (mysqli_query($conn, $query)) {
        echo json_encode([
            "success" => true,
            "message" => "Afspraak succesvol bijgewerkt"
        ]);
        // sendEmail(
        //     userid: $userid,
        //     subject: "Afspraak bijgewerkt",
        //     body: "Uw afspraak op $date om $time is bijgewerkt. Neem contact op met de praktijk als u vragen heeft.",
        //     conn: $conn
        // );
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Er is een fout opgetreden bij het bijwerken van de afspraak: " . mysqli_error($conn)
        ]);
    }
}