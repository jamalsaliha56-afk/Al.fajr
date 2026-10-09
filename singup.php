<?php

require_once __DIR__ . '/connect.php';
require_once __DIR__ . '/send_mail.php';

$message_status = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === "" || $email === "" || $password === "") {

        $message_status = "Please fill all fields.";

    } else {

        $check = $conn->prepare(
            "SELECT id FROM users WHERE email = ?"
        );

        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {

            $message_status = "Email already registered.";

        } else {

            $hashed_password = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $stmt = $conn->prepare(
                "INSERT INTO users (username, email, password)
                 VALUES (?, ?, ?)"
            );

            $stmt->bind_param(
                "sss",
                $username,
                $email,
                $hashed_password
            );

            if ($stmt->execute()) {

                $subject = "New Sign Up - Royal Website";

                $message = "
                    <h2>New User Registered</h2>

                    <p><strong>Username:</strong> "
                    . htmlspecialchars($username) .
                    "</p>

                    <p><strong>Email:</strong> "
                    . htmlspecialchars($email) .
                    "</p>

                    <p><strong>Time:</strong> "
                    . date("Y-m-d H:i:s") .
                    "</p>
                ";

                sendAdminAlert($subject, $message);

                $message_status = "Account created successfully!";

            } else {

                $message_status = "Database Error: " . $stmt->error;
            }

            $stmt->close();
        }

        $check->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
</head>

<body>

<?php
if ($message_status !== "") {
    echo "<p>" . htmlspecialchars($message_status) . "</p>";
}
?>

</body>
</html>