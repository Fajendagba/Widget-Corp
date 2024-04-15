<?php 
include ('includes/functions.php');
include ('config/setup.php');
include ('includes/header.php');

if (intval($_GET['page']) == 0) {
    redirect_to("content.php");
}
if (isset($_POST['submit'])) {
    $errors = array();

    $required_fields = array('menu_name', 'position', 'visible');
    foreach ($required_fields as $fieldname) {
        if (!isset($_POST[$fieldname]) || (empty($_POST[$fieldname]) && is_int($_POST[$fieldname]))) {
            $errors[] = $fieldname;
        }
    }

    $fields_with_length = array('menu_name' => 30);
    foreach ($fields_with_length as $fieldname => $maxlength) {
        if (strlen(trim(sanitizeString($_POST[$fieldname]))) > $maxlength) {
            $errors[] = $fieldname;
        }
    }
    
    if (empty($errors)) {
        $id   = sanitizeString($_GET['page']);
        $menu = trim(sanitizeString($_POST['menu_name']));
        $pos  = sanitizeString($_POST['position']);
        $vis  = sanitizeString($_POST['visible']);
        $con  = sanitizeString($_POST['content']);

        $action = 'updated';
        $q = "UPDATE pages SET menu_name = '$menu', position = '$pos', visible = $vis, content = '$con' WHERE id = '$id'";
        $r = mysqli_query($dbc, $q);

        if (mysqli_affected_rows($dbc) == 1) {
            $message = '<p class="alert alert-success">'.$_POST['menu_name'].' Was Updated</p>';
        } else {
            $message = '<p class="alert alert-warning">Subject could not be updated because:</p>'.
                    mysqli_error($dbc).'<br> <p class="alert alert-warning"> Query: '.$q.'</p>';
        }
    } elseif(!empty($errors)) {
        // Errors occured
        $message = '<p class="alert alert-warning"> '. count($errors).' Error Occured.</p>';
    }
}



?>
    <table id="structure">
        <tr>
            <td id="navigation">
                <ul class="subjects list-group">
                    <?php subjectData($dbc);?>
                </ul>
                <br>
                <a class="list-group-item" style="color: blue;" href="new-subject.php"><i class="fa fa-plus-square"></i> Add a new subject</a>
            </td>
            <?php
            $id = $_GET['page'];
            $q = "SELECT * FROM pages WHERE id=$id ORDER BY position ASC";
            $r = mysqli_query($dbc, $q);
            while ($sel_page = mysqli_fetch_assoc($r)) {?>
                <td id="page">
                    <h2>Edit<?php 
                    if (!is_null($sel_page)){
                        echo $name.': '.$sel_page['menu_name'];
                    }elseif (!is_null($sel_subj)){
                        echo $name.': '.$sel_subj['menu_name'];
                    }?></h2>
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
                    <form class="form-horizontal nav-form list-group-item" action="edit_page.php?page=<?php echo urlencode($sel_page['id'])?>" method="POST" role="form">

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="page_name">Page name:</label>
                            <div class="col-sm-5">
                                <input class="form-control input-sm" placeholder="Subject name" type="text" name="menu_name" id="menu" value="<?php echo $sel_page['menu_name'];?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="position">Position:</label>
                            <div class="col-sm-5">
                                <select class="form-control input-sm" name="position">
                                    <?php
                                    if (!$new_page) {
                                        $page_set = get_pages_for_subject($dbc, $sel_page['subject_id']);
                                        $page_count = mysqli_num_rows($page_set);
                                    } else {
                                        $page_set = get_pages_for_subject($dbc, $sel_subj['id']);
                                        $page_count = mysqli_num_rows($page_set)+1;
                                    }
                                    for ($count=1; $count<=$page_count;$count++){?>
                                        <option value='<?php echo $count;?>' <?php 
                                    if ($sel_page['position'] == $count) {
                                        echo " selected";
                                    }
                                    ?>><?php echo $count;?></option>
                                        <?php }?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="page_visibility">Visible:</label>
                            <div class="col-sm-5">
                                <input type="radio" name="visible" id="visible" value="0" <?php if ($sel_page['visible'] == 0) {echo " checked";}?>>No
                                <input type="radio" name="visible" id="visible" value="1" <?php if ($sel_page['visible'] == 1) {echo " checked";}?>>Yes
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="page_content">Content:</label>
                            <div class="col-sm-5">
                                <textarea class="form-control input-sm" name="content" rows="10" cols="40"><?php echo $sel_page['content'];?></textarea>
                                <!--<input class="form-control input-sm" placeholder="Subject name" type="text" name="menu_name" id="menu" value="<?php echo $sel_page['menu_name'];?>">-->
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="page_buttons"></label>
                            <div class="col-sm-5">
                                <button class="pull-left btn btn-default" style="color: blue;" name="submit" type="submit"><i class="fa fa-save"></i> Update Page</button>
                                <a onclick="return confirm('Are you sure you want to permanently delete this page?')" class="list-group-item pull-left subject-delete" style="color: blue;" href="delete_page.php?page=<?php echo $sel_page['id'];?>"><i class="fa fa-cut"></i> Delete page</a>
                                <a class="list-group-item pull-right" style="color: blue;" href="content.php?page=<?php echo $sel_page['id'];?>"><i class="fa fa-window-close"></i> Cancel</a>
                                <input type="hidden" name="submitted" value="1">
                            </div>
                        </div>
                    </form>                
                </td>
            <?php }?><!--End of td and the while loop-->
            
        </tr>
    </table>
<?php include ('includes/footer.php')?>





