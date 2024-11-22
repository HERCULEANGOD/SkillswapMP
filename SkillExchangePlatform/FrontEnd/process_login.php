<?php
session_start();


$host = 'localhost'; 
$dbname = 'SkillSwap'; 
$username = 'Saarthak'; 
$password = '12345'; 

try {
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $email = $_POST['email'];
        $password = $_POST['password'];

        
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

       
        if ($user && password_verify($password, $user['password'])) {
            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];

            
            header("Location: dashboard.php");
            exit();
        } else {
            
            $error = "Invalid email or password.";
        }
    }
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
}

if (isset($error)) {
    echo "<p style='color:red;'>$error</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Error</title>
</head>
<body>
    <h2>Login Error</h2>
    <p>Please try again or <a href="login.html">return to the login page</a>.</p>
</body>
</html>