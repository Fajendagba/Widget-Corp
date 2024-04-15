<?php 
include ('includes/functions.php');
include ('config/setup.php');
include ('includes/header.php');

if (intval($_GET['subj']) == 0) {
    redirect_to("content.php");
}

find_selected_page($dbc);
$page_data = pageContent($dbc);
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
            <td id="page">
            <?php
//            $id = $_GET['subj'];
            ?>
                <h2>Add page to<?php
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
                <form class="form-horizontal nav-form list-group-item" action="createpage.php?subj=<?php echo urlencode($sel_subj['id'])?>" method="POST" role="form">

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="page_name">Page name:</label>
                        <div class="col-sm-5">
                            <input class="form-control input-sm" placeholder="New Page name" type="text" name="menu_name" id="menu">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="position">Position:</label>
                        <div class="col-sm-5">
                            <select class="form-control input-sm" name="position">
                                <?php
                                    $page_set = get_pages_for_subject($dbc, $sel_subj['id']);
                                    $page_count = mysqli_num_rows($page_set)+1;
                                    
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
                            <input type="radio" name="visible" id="visible" value="0">No
                            <input type="radio" name="visible" id="visible" value="1">Yes
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="page_content">Content:</label>
                        <div class="col-sm-5">
                            <textarea class="form-control input-sm" name="content" rows="10" cols="40"></textarea>
                            <!--<input class="form-control input-sm" placeholder="Subject name" type="text" name="menu_name" id="menu" value="<?php echo $sel_page['menu_name'];?>">-->
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="page_buttons"></label>
                        <div class="col-sm-5">
                            <button class="pull-left btn btn-default" style="color: blue;" name="submit" type="submit"><i class="fa fa-save"></i>Add Page</button>
                            <a onclick="return confirm('Are you sure you want to permanently delete this page?')" class="list-group-item pull-left subject-delete" style="color: blue;" href="delete_page.php?page=<?php echo $sel_page['id'];?>"><i class="fa fa-cut"></i> Delete page</a>
                            <a class="list-group-item pull-right" style="color: blue;" href="content.php?page=<?php echo $sel_page['id'];?>"><i class="fa fa-window-close"></i> Cancel</a>
                            <input type="hidden" name="submitted" value="1">
                        </div>
                    </div>
                </form>                
            <?php ?><!--End of td and the while loop-->
            </td>
            
        </tr>
    </table>
<?php include ('includes/footer.php')?>





