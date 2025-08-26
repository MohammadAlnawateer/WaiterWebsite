<?php
session_start();

$valid_username = "admin";
$valid_password = "admin123";

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === $valid_username && $password === $valid_password) {
        $_SESSION['is_admin'] = true;
        header("Location: admin.php");
        exit();
    } else {
        $error = "❌ Invalid admin credentials.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 100px 20px;
            text-align: center;
        }

        .modern-menu {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(135deg, rgb(70, 75, 80), #0056b3);
            padding: 15px 20px;
            color: white;
            z-index: 1000;
        }

        .modern-menu .logo {
            font-size: 24px;
            font-weight: bold;
        }

        .modern-menu .menu-items {
            list-style: none;
            display: flex;
        }

        .modern-menu .menu-items li {
            margin: 0 15px;
        }

        .modern-menu .menu-items a {
            text-decoration: none;
            color: white;
            font-size: 18px;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .modern-menu .menu-items a:hover {
            color: #ffcc00;
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 28px;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
            }

            .modern-menu .menu-items {
                display: none;
                flex-direction: column;
                background: rgb(20, 21, 22);
                position: absolute;
                top: 60px;
                right: 0;
                width: 100%;
                text-align: center;
                padding: 10px 0;
            }

            .modern-menu .menu-items li {
                margin: 10px 0;
            }

            .modern-menu .menu-items.show {
                display: flex;
            }
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            width: 90%;
            max-width: 400px;
            margin: 120px auto 0 auto;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        h2 {
            margin-bottom: 20px;
        }

        input {
            width: 90%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        button {
            width: 95%;
            padding: 12px;
            background-color: #0056b3;
            color: white;
            border: none;
            font-size: 18px;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background-color: rgb(68, 78, 90);
        }

        .error {
            color: red;
            font-weight: bold;
            margin: 10px 0;
        }
    </style>
    <script>
        function toggleMenu() {
            document.querySelector(".menu-items").classList.toggle("show");
        }
    </script>
</head>
<body>

<nav class="modern-menu">
<div class="logo">M'dakhan Staff Portal</div>

    <button class="menu-toggle" onclick="toggleMenu()">☰</button>
    <ul class="menu-items">
        <li><a href="index.php">Waiter Login</a></li>
        <li><a href="admin_login.php">Admin Login</a></li>
    </ul>
</nav>

<div class="container">
    <h2>Admin Login</h2>
    <?php if ($error): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>
