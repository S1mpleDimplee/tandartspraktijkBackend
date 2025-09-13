<?php
function addUser($data, $conn)
{
    $firstName = $data['firstName'] ?? '';
    $lastName = $data['lastName'] ?? '';
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';

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

    if ($user && password_verify($password, $user['password'])) {
        echo json_encode([
            "success" => true,
            "message" => "Login successful",
            "userId" => $user['id']
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Invalid email or password"
        ]);
    }
}
?>