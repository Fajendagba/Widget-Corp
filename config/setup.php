<?php
error_reporting(0);

# These are my constants
define('DB_HOST', 'localhost');
define('DB_USER', 'widget_corp');
define('DB_PASS', 'MxRb3c264GoCCExn');
define('DB_NAME', 'widget_corp');

include ('includes/connection.php');

# Site Settings
$debug = data_settings_value($dbc, 'debug-status');

?>

