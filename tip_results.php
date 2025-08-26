<?php
if (
    $_SERVER["REQUEST_METHOD"] == "POST" &&
    isset($_POST['waiter_names'], $_POST['login_time'], $_POST['logout_time'], $_POST['worked_hours'], $_POST['tip_share'], $_POST['net_tip'])
) {
    // Retrieve form data
    $waiter_names = $_POST['waiter_names'];
    $login_times = $_POST['login_time'];
    $logout_times = $_POST['logout_time'];
    $worked_hours = $_POST['worked_hours'];
    $tip_shares = $_POST['tip_share'];
    $net_tip = floatval($_POST['net_tip']);

    $total_tip_distributed = array_sum($tip_shares);
    $total_seconds = 0;

    foreach ($worked_hours as $time) {
        list($h, $m) = explode(":", $time);
        $total_seconds += ($h * 3600) + ($m * 60);
    }

    $total_minutes = floor($total_seconds / 60);
    $total_hours = floor($total_minutes / 60);
    $remaining_minutes = $total_minutes % 60;
    $total_hours_formatted = sprintf("%02d:%02d", $total_hours, $remaining_minutes);

    $hourly_rate = $total_seconds > 0 ? ($net_tip / ($total_seconds / 3600)) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tip Distribution Results</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f4f4f4;
            color: #333;
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
            background: linear-gradient(135deg, #2c3e50, #007bff);
            padding: 15px 25px;
            color: white;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        .modern-menu .logo {
            font-size: 26px;
            font-weight: bold;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 700px;
            margin: 80px auto;
        }

        h2 {
            color: #007bff;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .result-box {
            background: #f8f9fa;
            padding: 12px;
            border-radius: 6px;
            font-size: 22px;
            font-weight: bold;
            margin: 10px 0;
            box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 14px;
            text-align: center;
        }

        th {
            background: #007bff;
            color: white;
            font-size: 18px;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        .btn {
            display: inline-block;
            background: #007bff;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<nav class="modern-menu">
    <div class="logo">MyWebsite</div>
</nav>

<div class="container">
    <h2>Tip Distribution Results</h2>

    <p><strong>Total Tips Distributed:</strong></p>
    <div class="result-box">\$<?php echo number_format($total_tip_distributed, 2); ?> of \$<?php echo number_format($net_tip, 2); ?></div>

    <p><strong>Total Hours Worked:</strong></p>
    <div class="result-box"><?php echo $total_hours_formatted; ?> hours</div>

    <p><strong>Hourly Rate (estimate):</strong></p>
    <div class="result-box">\$<?php echo number_format($hourly_rate, 2); ?> per hour</div>

    <h3>Waiter Tip Breakdown:</h3>
    <table>
        <tr>
            <th>Waiter Name</th>
            <th>Login Time</th>
            <th>Logout Time</th>
            <th>Work Hours</th>
            <th>Tip Share</th>
        </tr>

        <?php
        for ($i = 0; $i < count($waiter_names); $i++) {
            echo "<tr>
                    <td>" . htmlspecialchars($waiter_names[$i]) . "</td>
                    <td>" . htmlspecialchars($login_times[$i]) . "</td>
                    <td>" . htmlspecialchars($logout_times[$i]) . "</td>
                    <td>" . htmlspecialchars($worked_hours[$i]) . "</td>
                    <td>\$" . number_format($tip_shares[$i], 2) . "</td>
                  </tr>";
        }
        ?>
    </table>

    <a href="index.php" class="btn">⬅ Go Back</a>
</div>

</body>
</html>

<?php
} else {
    echo "<div class='error'>⚠ Invalid request. Please go back and enter the details.</div>";
}
?>
