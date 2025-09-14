<?php

function checkIfEmailExists($email, $conn)
{
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    return mysqli_num_rows($result) > 0;
}

function addUser($data, $conn)
{
    $firstName = $data['firstName'] ?? '';
    $lastName = $data['lastName'] ?? '';
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';

    if (checkIfEmailExists($email, $conn)) {
        echo json_encode([
            "success" => false,
            "message" => "Dit email adress is al geregistreerd, probeer een andere"
        ]);
        return;
    }

    if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
        echo json_encode([
            "success" => false,
            "message" => "Alle velden zijn verplicht"
        ]);
        return;
    }



    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (firstname, lastname, email, password) VALUES ('$firstName', '$lastName', '$email', '$hashedPassword')";

    mysqli_query($conn, $sql);

    echo json_encode([
        "success" => mysqli_affected_rows($conn) > 0,
        "message" => mysqli_affected_rows($conn) > 0 ? "User registered successfully" : "Registration failed",
        "userId" => mysqli_insert_id($conn)
    ]);
}

function checkLogin($data, $conn)
{
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc(result: $result);

    // $loggedInData = getLoginData($data, $conn);

    if ($user && password_verify($password, $user['password'])) {
        echo json_encode([
            "success" => true,
            "message" => "Login successful",
            "userId" => $user['id'],
            // "LoggedInData" => $loggedInData
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Email of wachtwoord is onjuist"
        ]);
    }
}


function getLoginData($data, $conn)
{
    $email = $data['email'] ?? '';

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc(result: $result);

    if ($user) {
        echo json_encode([
            "success" => true,
            "userId" => $user['id'],
            "firstName" => $user['firstname'],
            "lastName" => $user['lastname'],
            "email" => $user['email']
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "User not found"
        ]);
    }
}
?>