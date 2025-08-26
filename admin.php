<?php
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #ccc;
            padding: 20px;
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
        }
        .container {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 600px;
            margin: 100px auto 0 auto;
            text-align: center;
        }
        h2 {
            color: #2c3e50;
            margin-bottom: 20px;
        }
        .dashboard-links {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .dashboard-links a {
            background-color: #0056b3;
            color: white;
            text-decoration: none;
            padding: 15px;
            font-size: 18px;
            font-weight: bold;
            border-radius: 8px;
            transition: background 0.3s ease;
        }
        .dashboard-links a:hover {
            background-color: rgb(68, 78, 90);
        }
    </style>
</head>
<body>
<nav class="modern-menu">
<div class="logo">M'dakhan Staff Portal</div>

    <ul class="menu-items">
        <li><a href="#">Home</a></li>
        <li><a href="#">Reports</a></li>
        <li><a href="#">Settings</a></li>
    </ul>
</nav>
<div class="container">
    <h2>Admin Dashboard</h2>
    <div class="dashboard-links">
        <a href="tipcalculater.php">Tip Calculator</a>
        <a href="reports.php">Data Reports</a>
        <a href="managewaiters.php">Add/Delete Waiters</a>
        <a href="admin_logout.php">Logout</a>

    </div>
</div>
</body>
</html>
