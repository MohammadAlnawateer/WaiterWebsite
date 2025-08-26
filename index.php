<?php
include 'db_connect.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Authenticate user
    $sql = "SELECT * FROM Users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $user_id = $user['id'];

        // Check if there's an open shift
        $sql_shift = "SELECT * FROM WorkHours WHERE user_id = ? AND end_time IS NULL";
        $stmt_shift = $conn->prepare($sql_shift);
        $stmt_shift->bind_param("i", $user_id);
        $stmt_shift->execute();
        $result_shift = $stmt_shift->get_result();

        if ($result_shift->num_rows > 0) {
            // End the shift
            $shift = $result_shift->fetch_assoc();
            $shift_id = $shift['id'];

            $sql_end = "UPDATE WorkHours SET end_time = NOW() WHERE id = ?";
            $stmt_end = $conn->prepare($sql_end);
            $stmt_end->bind_param("i", $shift_id);
            $stmt_end->execute();

            $message = "✅ Shift ended successfully for <strong>$username</strong>.";
        } else {
            // Start a new shift
            $sql_start = "INSERT INTO WorkHours (user_id, start_time) VALUES (?, NOW())";
            $stmt_start = $conn->prepare($sql_start);
            $stmt_start->bind_param("i", $user_id);
            $stmt_start->execute();

            $message = "✅ Shift started successfully for <strong>$username</strong>.";
        }
    } else {
        $message = "<span style='color:red;'>❌ Invalid username or password.</span>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Waiter Shift Tracker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Your full original CSS, untouched */
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
            margin: 50px;
        }

        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            width: 50%;
            margin: auto;
        }

        label {
            font-size: 18px;
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        input {
            padding: 10px;
            margin: 10px 0;
            width: 90%;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            padding: 12px;
            background-color: rgb(90, 162, 177);
            color: white;
            border: none;
            cursor: pointer;
            font-size: 18px;
            border-radius: 5px;
            width: 95%;
            margin-top: 15px;
            transition: background 0.3s;
        }

        button:hover {
            background-color: rgb(54, 114, 41);
        }

        @media (max-width: 600px) {
            .container {
                width: 90%;
            }
            input {
                width: 95%;
            }
            button {
                width: 100%;
            }
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
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
        <li><a href="#">Home</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Services</a></li>
        <li><a href="admin.php">Admin</a></li> 
        <li><a href="#">Contact</a></li>
    </ul>
</nav>

<br><br><br>

<div class="container">
    <h2>Waiter Shift Manager</h2>
    <?php if ($message): ?>
        <p style="font-size: 18px; margin-bottom: 20px;"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <button type="submit">Start or End Shift</button>
    </form>
</div>

</body>
</html>
