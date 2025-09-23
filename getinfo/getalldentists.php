<?php


function getAllDentists($conn)
{
    $sql = "SELECT CONCAT(firstname, ' ', lastname) AS name, userid FROM users WHERE role = 1";
    $result = mysqli_query($conn, $sql);
    $dentists = mysqli_fetch_all($result, MYSQLI_ASSOC);
 

    if (!$dentists) {
        echo json_encode([
            "success" => false,
            "message" => "No dentists found",
            "data" => []
        ]);
        return;
    }

    echo json_encode([
        "success" => true,
        "message" => "All dentists retrieved successfully",
        "data" => $dentists
    ]);
    return;
}
