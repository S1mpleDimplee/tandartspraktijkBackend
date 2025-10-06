<?php
function sendEmail($userid, $subject, $body, $conn)
{
    // $sqlGetEmail = "SELECT email FROM users WHERE userid = '$userid'";
    // $result = mysqli_query($conn, $sqlGetEmail);
    // $email = mysqli_fetch_assoc($result);

    // if (!$email) {
    //     return json_encode([
    //         "success" => false,
    //         "message" => "Email van de gebruiker niet gevonden",
    //         "data" => null
    //     ]);
    // }

    // $to = $email['email'];
    // $headers = "From: no-reply@tandartspraktijk.nl";
    // $mailSent = mail($to, $subject, $body, $headers);
    // if ($mailSent) {
    //     return json_encode([
    //         "success" => true,
    //         "message" => "E-mail succesvol verzonden",
    //         "data" => null
    //     ]);
    // } else {
    //     return json_encode([
    //         "success" => false,
    //         "message" => "E-mail kon niet worden verzonden",
    //         "data" => null
    //     ]);
    // }

    $to = "jaylanovanderveen@gmail.com";
    $subject = "Testmail";
    $body = "Dit is een testmail via PHP mail() in XAMPP.";
    $headers = "From: no-reply@tandartspraktijk.nl";

    if (mail($to, $subject, $body, $headers)) {
        echo "Mail verzonden!";
    } else {
        echo "Mail mislukt!";
    }
}

