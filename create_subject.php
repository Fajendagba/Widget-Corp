<?php 
include ('includes/functions.php');
include ('config/setup.php');

$menu = sanitizeString($_POST['menu_name']);
$pos  = sanitizeString($_POST['position']);
$vis  = sanitizeString($_POST['visible']);

$q = "INSERT INTO subjects (menu_name, position, visible) "
        . "VALUES ('$menu', '$pos', '$vis')";
if (mysqli_query($dbc, $q)) {
    header("Location: content.php");
} else {
    echo '<p>Subject creation failed!</p><br>';
    echo $q.'<br>';
    echo '<p>'. mysqli_error($dbc).'</p>';
}

?>