<?php

function checkIfAppointmentTimeIsUsed($date, $time, $dentistid, $userid, $conn)
{
    $sql = "SELECT * FROM appointments WHERE date = '$date' AND time = '$time' AND (dentistid = '$dentistid' OR userid = '$userid')";
    $result = mysqli_query($conn, $sql);
    return mysqli_num_rows($result) > 0;
}