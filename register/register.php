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
    echo json_encode([
        "success" => mysqli_affected_rows($conn) > 0,
        "message" => mysqli_affected_rows($conn) > 0 ? "User registered successfully" : "Registration failed",
        "userId" => mysqli_insert_id($conn)
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
            "userId" => $user['id'], // Returns the user ID upon successful login to fetch the rest of user data
            // "LoggedInData" => $loggedInData
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Email of wachtwoord is onjuist, probeer het opnieuw"
        ]);
    }
}

?>