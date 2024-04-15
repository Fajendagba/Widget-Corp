<?php
# Database connection HERE...
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or
        die('Could not connect to database because: '. mysqli_connect_error());

?>