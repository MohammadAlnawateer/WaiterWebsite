<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tip Calculator</title>
    <style>
        /* General Page Styling */
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
            margin: 50px;
        }

        /* Centered Form Container */
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            width: 50%;
            margin: auto;
        }

        /* Form Labels */
        label {
            font-size: 18px;
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        /* Input Fields */
        input {
            padding: 10px;
            margin: 10px 0;
            width: 90%;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        /* Submit Button */
        button {
            padding: 12px;
            background-color:rgb(90, 162, 177);
            color: white;
            border: none;
            cursor: pointer;
            font-size: 18px;
            border-radius: 5px;
            width: 95%;
            margin-top: 15px;
            transition: background 0.3s;
        }

        /* Button Hover Effect */
        button:hover {
            background-color:rgb(54, 114, 41);
        }

        /* Responsive Design */
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
        position: fixed; /* Keeps the menu bar fixed at the top */
        top: 0;
        left: 0;
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: linear-gradient(135deg,rgb(70, 75, 80), #0056b3);
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
            background:rgb(20, 21, 22);
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
</head>
<body>
<nav class="modern-menu">
<div class="logo">M'dakhan Staff Portal</div>

    <button class="menu-toggle" onclick="toggleMenu()">☰</button>
    <ul class="menu-items">
        <li><a href="index.php">Home</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Services</a></li>
        <li><a href="#">Portfolio</a></li>
        <li><a href="#">Contact</a></li>
    </ul>
</nav>




<br><br><br>


    <div class="container">
        <h2>Tip Distribution Form</h2>
        <form action="tip_summary.php" method="POST">
            <label>Total Tips Earned ($):</label>
            <input type="number" step="0.01" name="total_tips" placeholder="Enter total tips" required>

             
            <button type="submit">Calculate Tips</button>
        </form>
    </div>

</body>
</html>
