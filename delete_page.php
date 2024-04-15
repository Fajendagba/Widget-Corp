<?php 
include ('includes/functions.php');
include ('config/setup.php');

if (intval($_GET['page']) == 0) {
    redirect_to("content.php");
}
$id = sanitizeString($_GET['page']);
if ($page = pagesContent($dbc, $id)) {
    $q = "DELETE FROM pages WHERE id = $id LIMIT 1";
    $r = mysqli_query($dbc, $q);

    if (mysqli_affected_rows($dbc) == 1) {
        $message = '<p class="alert alert-success"> Page Was Deleted</p>';
        redirect_to("content.php");
    } else {
        $message = '<p class="alert alert-warning">Page could not be deleted because:</p>'.
                mysqli_error($dbc).'<br> <p class="alert alert-warning"> Query: '.$q.'</p>';
        $message = '<a class="list-group-item pull-right alert alert-warning" style="color: blue;" href="content.php"><i class="fa fa-window-close"></i>Page Content</a>';
    }
} else {
    $message = '<p class="alert alert-warning"> Page does not exist!</p>';
    $message = '<a class="list-group-item pull-right alert alert-warning" style="color: blue;" href="content.php"><i class="fa fa-window-close"></i>Page Content</a>';
}