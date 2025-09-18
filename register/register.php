<?php

function checkIfEmailExists($email, $conn)
{
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    return mysqli_num_rows($result) > 0;
}

function addUser($data, $conn)
{
    $firstName = $data['firstName'] ?? null;
    $lastName = $data['lastName'] ?? null;
    $email = $data['email'] ?? null;
    $password = $data['password'] ?? null;

    // First check if email is already in use if so succes = false and return a error message
    if (checkIfEmailExists($email, $conn)) {
        echo json_encode([
            "success" => false,
            "message" => "Dit email adress is al geregistreerd, probeer een andere"
        ]);
        return;
    }

    // If any of the fields are empty return an error message
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
        echo json_encode([
            "success" => false,
            "message" => "Alle velden zijn verplicht"
        ]);
        return;
    }

    // Hases the passowrd
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


    $sql = "INSERT INTO users (firstname, lastname, email, password) VALUES ('$firstName', '$lastName', '$email', '$hashedPassword')";
    mysqli_query($conn, $sql);

    // Get the user id after adding
    $newId = mysqli_insert_id($conn);

    // Create a format for the user id with the new ID
    $userId = 'U-' . str_pad($newId, 5, '0', STR_PAD_LEFT);

    // Update the user record with the generated userid
    $updateSql = "UPDATE users SET userid='$userId' WHERE id=$newId";
    mysqli_query($conn, $updateSql);

    echo json_encode([
        "success" => mysqli_affected_rows($conn) > 0,
        "message" => mysqli_affected_rows($conn) > 0 ? "User registered successfully" : "Registration failed",
        "userId" => $userId
    ]);
}

function checkLogin($data, $conn)
{
    $email = $data['email'] ?? null;
    $password = $data['password'] ?? null;

    $sql = "SELECT * FROM users WHERE email='$email'";

    $result = mysqli_query($conn, $sql);

    $user = mysqli_fetch_assoc($result);

    // $loggedInData = getLoginData($data, $conn);
    // if (is_null($email)) {
    //     echo json_encode([
    //         "success" => false,
    //         "message" => "Email bestaat niet"
    //     ]);
    // }

    if ($user && password_verify($password, $user['password'])) {
        echo json_encode([
            "success" => true,
            "message" => "Login successful",
            "data" => [
                "id" => $user['id'],
                "firstName" => $user['firstname'],
                "lastName" => $user['lastname'],
                "email" => $user['email'],
                "role" => $user['role'],
                "userid" => $user['userid']

            ],
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Email of wachtwoord is onjuist, probeer het opnieuw"
        ]);
    }
}
