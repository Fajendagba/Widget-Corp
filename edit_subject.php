<?php 
include ('includes/functions.php');
include ('config/setup.php');
include ('includes/header.php');

if (intval($_GET['subj']) == 0) {
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
        $id   = sanitizeString($_GET['subj']);
        $menu = sanitizeString($_POST['menu_name']);
        $pos  = sanitizeString($_POST['position']);
        $vis  = sanitizeString($_POST['visible']);

        $action = 'updated';
        $q = "UPDATE subjects SET menu_name = '$menu', position = '$pos', visible = $vis WHERE id = '$id'";
        $r = mysqli_query($dbc, $q);

        if (mysqli_affected_rows($dbc) == 1) {
            $message = '<p class="alert alert-success"> Subject Was Updated</p>';
        } else {
            $message = '<p class="alert alert-warning">Subject could not be updated because:</p>'.
                    mysqli_error($dbc).'<br> <p class="alert alert-warning"> Query: '.$q.'</p>';
        }
    } elseif(!empty($errors)) {
        // Errors occured
        $message = '<p class="alert alert-warning"> '. count($errors).' Error Occured.</p>';
    }
}

find_selected_page($dbc);

$subj_data = subjectContent($dbc);
?>
    <table id="structure">
        <tr class="row">
            <td id="navigation" class="col-md-6">
                <ul class="subjects list-group">
                    <?php subjectData($dbc);?>
                </ul>
            </td>
            <td id="page" class="col-md-6">
                <div class="row"> 
                    <div class="col-md-6">
                        <h2>Edit<?php 
                        if (!is_null($sel_subj)){
                            echo $name.': '.$sel_subj['menu_name'];
                        }elseif (!is_null($sel_page)){
                            echo $name.': '.$sel_page['menu_name'];
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
                        
                        <form class="form-horizontal nav-form list-group-item" action="edit_subject.php?subj=<?php echo urlencode($sel_subj['id'])?>" method="POST" role="form">

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="sub_name">Subject name:</label>
                                <div class="col-sm-5">
                                    <input class="form-control input-sm" placeholder="Subject name" type="text" name="menu_name" id="menu" value="<?php echo $sel_subj['menu_name'];?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="position">Position:</label>
                                <div class="col-sm-5">
                                    <select class="form-control input-sm" name="position">
                                        <?php 
                                        $subj_count = mysqli_num_rows($subj_data);
                                        for ($count=1; $count<=$subj_count+1;$count++){?>
                                            <option value='<?php echo $count;?>' <?php 
                                        if ($sel_subj['position'] == $count) {
                                            echo " selected";
                                        }
                                        ?>><?php echo $count;?></option>
                                            <?php }?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="sub_name">Visible:</label>
                                <div class="col-sm-10">
                                    <input type="radio" name="visible" id="visible" value="0" <?php if ($sel_subj['visible'] == 0) {echo " checked";}?>>No
                                    <input type="radio" name="visible" id="visible" value="1" <?php if ($sel_subj['visible'] == 1) {echo " checked";}?>>Yes
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="sub_name"></label>
                                <div class="col-sm-7">
                                    <button class="pull-left btn btn-default" style="color: blue;" name="submit" type="submit"><i class="fa fa-save"></i> Save</button>
                                    <a onclick="return confirm('Are you sure you want to permanently delete this subject?')" class="list-group-item pull-left subject-delete" style="color: blue;" href="delete_subject.php?subj=<?php echo $sel_subj['id'];?>"><i class="fa fa-cut"></i> Delete</a>
                                    <a class="list-group-item pull-right" style="color: blue;" href="content.php"><i class="fa fa-window-close"></i> Cancel</a>
                                    <input type="hidden" name="submitted" value="1">
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <div class="col-md-6"> 
                        <div class="list-group">
                            <h2>Pages in this subject:</h2>
                            <ul class="col-md-12">
                                <?php
                                $subject_pages = get_pages_for_subject($dbc, $sel_subj['id']);
                                while ($page = mysqli_fetch_assoc($subject_pages)) {?>
                                <li class="list-group-item" style="width: 50%;">
                                    <a style="color: blue;" href="edit_page.php?page=<?php echo $page['id']?>"><?php echo $page['menu_name']?></a></li>
                                <?php }?>
                            </ul>
                            <div class="col-sm-5">
                                <a class="list-group-item pull-right" style="color: blue;" href="new_page.php?subj=<?php echo $sel_subj['id'];?>">
                                    <i class="fa fa-plus-square"></i> Add a new page to this subject</a>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>
<?php include ('includes/footer.php')?>





