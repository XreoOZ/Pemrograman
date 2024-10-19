    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            background-color: #2c2c2c;
            color: #e0e0e0; 
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        
        .login-container {
            max-width: 400px;
            margin: 100px auto; 
            padding: 20px;
            background-color: #3a3a3a; 
            border-radius: 8px; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); 
        }

        h2 {
            text-align: center;
            color: #ffffff; 
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input[type="text"],
        input[type="password"] {
            width: 95%;
            padding: 10px;
            border: none;
            border-radius: 4px; 
            margin-bottom: 15px; 
            background-color: #5a5a5a; 
            color: #ffffff; 
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white; 
            padding: 10px;
            border: none;
            border-radius: 4px; 
            cursor: pointer; 
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #45a049; 
        }

        .error {
            color: #ff4d4d; 
            text-align: center;
            margin-top: 10px; 
        }
    </style>
</head>
<body>
    <?php
    session_start(); 
    ini_set('display_errors', 1); 
    error_reporting(E_ALL); 

    include 'database.php'; 

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        
        $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password);
            $stmt->fetch();
            if (hash_equals($hashed_password, hash('sha256', $password))) {
                $_SESSION['loggedin'] = true; 
                header("Location: portofolio.html"); 
                exit(); 
            } else {
                echo "<div class='error'>Invalid username or password.</div>"; 
            }
        } else {
            echo "<div class='error'>Invalid username or password.</div>"; 
        }
        $stmt->close();
    }

    $conn->close(); 
    ?>
    <div class="login-container">
        <h2>Login</h2>
        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" name="username" required><br>
            <label for="password">Password:</label>
            <input type="password" name="password" required><br>
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html> 