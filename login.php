<?php


// ... rest of your code

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
include 'db.php'; // Make sure this connects correctly

$error = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and fetch input
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Hash password only if stored as MD5 (consider password_hash for production)
    $hashed_password = md5($password);

    // Prepare and execute SQL statement
    $stmt = $conn->prepare("SELECT * FROM login_users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $hashed_password);
    $stmt->execute();
    $res = $stmt->get_result();

    // Check for valid user
    if ($res->num_rows === 1) {
        $_SESSION['username'] = $username;

        // Redirect to index.html
        header("Location: index.html");
    
        exit();
    } 
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Hotel Management</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('images/food_2.jpeg'); /* Replace with your image path */
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
        }
        .login-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            max-width: 350px;
            margin: 100px auto;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Login</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit">Login</button>
            <?php if (!empty($error)) : ?>
                <p class="error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
        </form>
    </div>

</body>
</html>
