<?php 
include ('includes/functions.php');
include ('config/setup.php');
include ('includes/header.php');

global $sel_page;
global $sel_subj;
if (isset($_GET['subj'])){
    $sel_subj = subjContent($dbc, $_GET['subj']);
    $name     = "Subject";
    $sel_page = NULL;
} elseif (isset($_GET['page'])) {
    $sel_page = pagesContent($dbc, $_GET['page']);
    $name     = "Page";
    $sel_subj = NULL;
} else {
    $sel_page = NULL;
    $name     = NULL;
    $sel_subj = NULL;
}
$subj_data = subjectContent($dbc);
?>
    <table id="structure">
        <tr>
            <td id="navigation">
                <ul class="subjects list-group">
                    <?php subjectData($dbc);?>
                </ul>
            </td>
            <td id="page">
                <h2>Add Subject</h2>
                <form class="form-horizontal nav-form list-group-item" action="create_subject.php" method="POST" role="form">
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="sub_name">Subject name:</label>
                        <div class="col-sm-5">
                            <input class="form-control input-sm" placeholder="Subject name" type="text" name="menu_name" id="menu">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="position">Position:</label>
                        <div class="col-sm-5">
                            <select class="form-control input-sm" name="position">
                                <?php 
                                $subj_count = mysqli_num_rows($subj_data);
                                for ($count=1; $count<=$subj_count+1;$count++){
                                    echo "<option value='$count'>$count</option>";
                                }
                                ?>                                
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="sub_name">Visible:</label>
                        <div class="col-sm-5">
                            <input type="radio" name="visible" id="visible" value="0">No
                            <input type="radio" name="visible" id="visible" value="1">Yes
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="sub_name"></label>
                        <div class="col-sm-5">
                            <input type="submit" value="Save">
                            <!--<button class="list-group-item" style="color: blue;" type="submit"><i class="fa fa-save"></i> Save</button>-->
                            <a class="list-group-item pull-right" style="color: blue;" href="content.php"><i class="fa fa-save"></i> Cancel</a>
                            <input type="hidden" name="submitted" value="1">
                        </div>
                    </div>
                </form>
                
                
            </td>
        </tr>
    </table>
<?php include ('includes/footer.php')?>






