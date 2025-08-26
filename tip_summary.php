<?php
// 1. Connect to the database
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "waiterwebsite";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$now = new DateTime();
if ((int)$now->format('H') < 6) {
    $start = $now->modify('-1 day')->format('Y-m-d 06:00:00');
    $end = date('Y-m-d 05:59:59');
} else {
    $start = date('Y-m-d 06:00:00');
    $end = date('Y-m-d 05:59:59', strtotime('+1 day'));
}

$sql = "SELECT 
            Users.username, 
            WorkHours.start_time AS login_time, 
            WorkHours.end_time AS logout_time
        FROM WorkHours
        JOIN Users ON WorkHours.user_id = Users.id
        WHERE WorkHours.start_time >= '$start' AND WorkHours.start_time <= '$end'";

$result = $conn->query($sql);
$waiters = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $waiters[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tip Calculation Results</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            text-align: center;
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
            max-width: 80%;
            margin: 100px auto 0 auto;
        }
        h2 {
            color: #2c3e50;
            margin-bottom: 20px;
        }
        .result {
            font-size: 22px;
            color: rgb(41, 49, 44);
            font-weight: bold;
        }
        .error {
            color: red;
            font-weight: bold;
        }
        form {
            margin-top: 20px;
        }
        .separator {
            width: 90%;
            max-width: 500px;
            height: 4px;
            background: linear-gradient(90deg, #007bff, #0056b3);
            margin: 30px auto;
            border-radius: 2px;
        }
        .table-container {
            overflow-x: auto;
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
        input {
            width: 95%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
        }
        button {
            width: 100%;
            margin-top: 20px;
            padding: 12px;
            background-color: #0056b3;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: rgb(68, 78, 90);
        }
    </style>
</head>
<body>
<nav class="modern-menu">
<div class="logo">M'dakhan Staff Portal</div>

    <ul class="menu-items">
        <li><a href="index.php">Home</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Services</a></li>
        <li><a href="#">Contact</a></li>
    </ul>
</nav>
<div class="container">
    <h2>Waiter Work Hours</h2>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $total_tips = floatval($_POST["total_tips"]);
        $tip_out = $total_tips * 0.10;
        $net_tip = $total_tips - $tip_out;

        echo "<p>Total Tips Earned: <span class='result'>\$" . number_format($total_tips, 2) . "</span></p>";
        echo "<p>Tip Out (10%): <span class='result'>\$" . number_format($tip_out, 2) . "</span></p>";
        echo "<p>Net Tip After Tip Out: <span class='result'>\$" . number_format($net_tip, 2) . "</span></p>";
    } else {
        echo "<p class='error'>Invalid request. Please go back and enter the details.</p>";
    }
    ?>
    <div class="separator"></div>
    <form action="tip_results.php" method="POST">
        <input type="hidden" name="net_tip" value="<?php echo isset($net_tip) ? $net_tip : 0; ?>">
        <div class="table-container">
            <table>
                <tr>
                    <th>Waiter Name</th>
                    <th>Login Time</th>
                    <th>Logout Time</th>
                    <th>Work Hours</th>
                </tr>
                <?php
                if (!empty($waiters)) {
                    $worked_data = [];
                    $total_seconds = 0;

                    foreach ($waiters as $row) {
                        if (!empty($row['login_time']) && !empty($row['logout_time'])) {
                            $login = strtotime($row['login_time']);
                            $logout = strtotime($row['logout_time']);
                            $worked_seconds = max(0, $logout - $login);

                            if (!isset($worked_data[$row['username']])) {
                                $worked_data[$row['username']] = [
                                    'worked_seconds' => 0,
                                    'first_login' => $row['login_time'],
                                    'last_logout' => $row['logout_time']
                                ];
                            }

                            $worked_data[$row['username']]['worked_seconds'] += $worked_seconds;

                            if ($row['login_time'] < $worked_data[$row['username']]['first_login']) {
                                $worked_data[$row['username']]['first_login'] = $row['login_time'];
                            }
                            if ($row['logout_time'] > $worked_data[$row['username']]['last_logout']) {
                                $worked_data[$row['username']]['last_logout'] = $row['logout_time'];
                            }

                            $total_seconds += $worked_seconds;
                        }
                    }

                    $total_hours = floor($total_seconds / 3600);
                    $total_minutes = floor(($total_seconds % 3600) / 60);
                    $formatted_total = sprintf("%02d:%02d", $total_hours, $total_minutes);

                    $hourly_rate = $total_seconds > 0 ? ($net_tip / ($total_seconds / 3600)) : 0;
                    if ($hourly_rate > $net_tip) {
                        $hourly_rate = $net_tip;
                    }

                    echo "<p><strong>Total Hours Worked:</strong> $formatted_total hours</p>";
                    echo "<p><strong>Hourly Rate:</strong> \$" . number_format($hourly_rate, 2) . " per hour</p>";

                    foreach ($worked_data as $username => $data) {
                        $hours = floor($data['worked_seconds'] / 3600);
                        $minutes = floor(($data['worked_seconds'] % 3600) / 60);
                        $work_hours = sprintf("%02d:%02d", $hours, $minutes);

                        $share = ($total_seconds > 0 && isset($net_tip)) ? round(($data['worked_seconds'] / $total_seconds) * $net_tip, 2) : 0;

                        echo "<tr>";
                        echo "<input type='hidden' name='waiter_names[]' value='" . htmlspecialchars($username) . "'>";
                        echo "<input type='hidden' name='login_time[]' value='" . htmlspecialchars($data['first_login']) . "'>";
                        echo "<input type='hidden' name='logout_time[]' value='" . htmlspecialchars($data['last_logout']) . "'>";
                        echo "<input type='hidden' name='worked_hours[]' value='" . $work_hours . "'>";
                        echo "<input type='hidden' name='tip_share[]' value='" . $share . "'>";
                        echo "<td><input type='text' value='" . htmlspecialchars($username) . "' readonly></td>";
                        echo "<td><input type='text' value='" . $data['first_login'] . "' readonly></td>";
                        echo "<td><input type='text' value='" . $data['last_logout'] . "' readonly></td>";
                        echo "<td>" . $work_hours . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No valid work hours found.</td></tr>";
                }
                ?>
            </table>
        </div>
        <button type="submit">Submit Data</button>
    </form>
</div>
</body>
</html>
<?php $conn->close(); ?>
