<?php 
include ('includes/functions.php');
include ('config/setup.php');
include ('includes/header.php');


if (isset($_POST['submit'])) {
    $errors = array();

    $required_fields = array('username', 'password');
    foreach ($required_fields as $fieldname) {
        if (!isset($_POST[$fieldname]) || (empty($_POST[$fieldname]) && is_int($_POST[$fieldname]))) {
            $errors[] = $fieldname;
        }
    }
    
    if (empty($errors)) {
        $username = sanitizeString($_POST['username']);
        if ($_POST['password'] !=""){
            if ($_POST['password'] == $_POST['vpassword']) {
                $password = sanitizeString(SHA1($_POST['password']));
                $verify =  true;
            } elseif ($_POST['password'] != $_POST['vpassword']) {
                $errors = '<p class="alert alert-warning">The password does not match</p>';
                $verify =  false;
            }
        } else {
            $verify =  false;
        }
        
        $q = "SELECT username FROM users WHERE username ='$username'";
        $r = mysqli_query($dbc, $q);
        if (mysqli_num_rows($r)>0) {
            $message = '<p class="alert alert-warning"><strong>'.$_POST['username'].'</strong> already exist.<br>Try another username</p>';
            $verify = FALSE;
        } else {
            $q = "INSERT INTO users (username, hashed_password) "
            . "VALUES ('$username', '$password')";
            if ($verify == true) {
                $r = mysqli_query($dbc, $q);
            }
            
            if ($r) {
                $message = '<p class="alert alert-success">'.$_POST['username'].' has been added as a new Staff</p>';
            } else {
                $message = '<p class="alert alert-warning">'.$_POST['username'].' could not be added because:</p>'.
                        mysqli_error($dbc).'<br> <p class="alert alert-warning"> Query: '.$q.'</p>';
            }
        }
    } elseif(!empty($errors)) {
        // Errors occured
        $message = '<p class="alert alert-warning"> '. count($errors).' Error Occured.</p>';
    }
}

?>



<table id="structure">
    <tr>
        <td id="page">            
            <div class="container">
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel panel-default" id="login-container">
                        <div class="panel-heading">
                            <h4><strong>Add New User</strong></h4>
                        </div>
                        <div class="panel-body">
                            <?php
                            if (!empty($message)) {
                                echo $message;
                            }
                            if (!empty($errors)) {?>
                            <p class="alert alert-warning">
                                Please review the following fields:<br>
                                <?php foreach ($errors as $error) {
                                    echo " - ".$error."<br>";
                                }?>
                            </p>
                            <?php }?>
                            <form action="new_user.php" method="post" role="form">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" name="username" id="username" placeholder="Enter Username">
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail">Password</label>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password">
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail">Verify password</label>
                                    <input type="password" class="form-control" name="vpassword" id="vpassword" placeholder="Enter password again">
                                </div>
                                <button type="submit" name="submit" class="btn btn-block">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>
</table>



    



<?php include ('includes/footer.php');
?>