<?php
session_start();
require_once 'db.php';

if (isset($_SESSION['user_id'])) {
    header("Location: options.php");
    exit();
}

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error_message = "Please fill in all fields.";
    } else {
        $stmt = $pdo->prepare("SELECT id, password_hash FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();  

        if (!$user) {
            $error_message = "User not available.";
        } elseif (!password_verify($password, $user['password_hash'])) {
            $error_message = "Incorrect password.";
        } else {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['email'] = $email;
    header("Location: options.php");
    exit();
}

    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Study Assist - Login</title>
<!-- Your updated CSS -->
<link rel="stylesheet" href="login.css" />
</head>
<body>

<header>
    <h1>Login to Study Assist</h1>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="signup.php">Sign Up</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="login-container">
        <h2>Login</h2>

        <?php if (!empty($error_message)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

      <form action="login.php" method="POST" autocomplete="off">
    <!-- email and password fields -->
    <div class="form-group">
        <label for="email">Email:</label>
        <input 
            type="email" 
            id="email" 
            name="email" 
            required 
            value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
        >
    </div>

    <div class="form-group">
        <label for="password">Password:</label>
        <input 
            type="password" 
            id="password" 
            name="password" 
            required
        >
    </div>

    
    <button type="submit">Login</button>
</form>

        <p>Don't have an account? <a href="signup.php">Sign Up here</a>.</p>
    </section>
</main>

<footer>
    <p>© <?php echo date("Y"); ?> Study Assist. All rights reserved.</p>
</footer>

<script src="js/script.js"></script>
</body>
</html>