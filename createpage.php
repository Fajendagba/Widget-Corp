<?php 
include ('includes/functions.php');
include ('config/setup.php');

$id   = $_GET['subj'];
$menu = sanitizeString($_POST['menu_name']);
$pos  = sanitizeString($_POST['position']);
$vis  = sanitizeString($_POST['visible']);
$con  = sanitizeString($_POST['content']);

$q = "INSERT INTO pages (menu_name, position, visible, content, subject_id) "
        . "VALUES ('$menu', '$pos', '$vis', '$con', $id)";
if (mysqli_query($dbc, $q)) {
    header("Location: content.php");
} else {
    
    echo '<p class="alert alert-warning">Page could not be added because:</p>'.
                    mysqli_error($dbc).'<br> <p class="alert alert-warning"> Query: '.$q.'</p>';
}

?>