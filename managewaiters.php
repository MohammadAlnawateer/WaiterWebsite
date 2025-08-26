<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "waiterwebsite";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Add Waiter
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = 'waiter'; // default role

    if (!empty($username) && !empty($password)) {
        $stmt = $conn->prepare("INSERT INTO Users (username, password, role, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("sss", $username, $password, $role);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: managewaiters.php");
    exit;
}

// Handle Delete
if (isset($_GET['delete'])) {
    $deleteId = intval($_GET['delete']);
    $conn->query("DELETE FROM Users WHERE id = $deleteId");
    header("Location: managewaiters.php");
    exit;
}

// Fetch all waiters
$result = $conn->query("SELECT id, username, password, role, created_at FROM Users WHERE role = 'waiter'");
$waiters = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Waiters</title>
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
            max-width: 800px;
            margin: 100px auto 0 auto;
        }
        input, button {
            padding: 10px;
            margin: 5px;
            width: 90%;
            max-width: 300px;
            font-size: 16px;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 10px;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        a {
            color: red;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<nav class="modern-menu">
<div class="logo">M'dakhan Staff Portal</div>

    <ul class="menu-items">
        <li><a href="index.php">Home</a></li>
        <li><a href="dashboard.php">Dashboard</a></li>
    </ul>
</nav>
<div class="container">
    <h2>Add New Waiter</h2>
    <form method="POST" action="">
        <input type="text" name="username" placeholder="Waiter Name" required><br>
        <input type="text" name="password" placeholder="Password" required><br>
        <button type="submit">Add Waiter</button>
    </form>

    <h2>All Waiters</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Password</th>
            <th>Role</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>
        <?php foreach ($waiters as $row): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['username']); ?></td>
                <td><?php echo htmlspecialchars($row['password']); ?></td>
                <td><?php echo htmlspecialchars($row['role']); ?></td>
                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                <td><a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>
<?php $conn->close(); ?>
