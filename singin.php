<?php

include 'connect.php';
include_once 'send_mail.php';

$message_status = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email    = trim($_POST['jamalsaliha56@gmail.com'] ?? '');
    $password = $_POST['ojfykezugvbvgffc
'] ?? '';

    if ($email == "" || $password == "") {

        $message_status = "Please enter email and password.";

    } else {

        $stmt = $conn->prepare(
            "SELECT id, username, email, password
             FROM users
             WHERE email = ?"
        );

        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows == 1) {

            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {

                // Email notification
                $subject = "New Sign In - My Website";

                $message = "
                    <h2>User Signed In</h2>

                    <p>
                        <strong>Username:</strong>
                        " . htmlspecialchars($user['username']) . "
                    </p>

                    <p>
                        <strong>Email:</strong>
                        " . htmlspecialchars($user['email']) . "
                    </p>

                    <p>
                        <strong>Time:</strong>
                        " . date("Y-m-d H:i:s") . "
                    </p>
                ";

                sendAdminAlert($subject, $message);

                $message_status = "Sign In Successful!";

            } else {

                $message_status = "Invalid email or password.";
            }

        } else {

            $message_status = "Invalid email or password.";
        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign In</title>
</head>

<body>

<?php
if ($message_status != "") {
    echo "<p>" . htmlspecialchars($message_status) . "</p>";
}
?>

</body>
</html>