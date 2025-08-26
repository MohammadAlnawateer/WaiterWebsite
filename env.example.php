<?php
// Copy this file to env.php and put your real credentials there (do NOT commit env.php)
define('DB_HOST', 'localhost');
define('DB_NAME', 'waiter_db');
define('DB_USER', 'waiter_user');
define('DB_PASS', 'REPLACE_ME_STRONG_PASSWORD');
define('DB_CHARSET', 'utf8mb4');

// App
define('APP_NAME', 'WaiterWebsite');
define('APP_SESSION', 'waiter_sess');

// Business rules
define('TIPOUT_PERCENT', 3.0);   // e.g., 3 = 3%
define('TIPOUT_BASE', 'sales');  // 'sales' or 'tips'
