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
                <br>
                <a class="list-group-item" style="color: blue;" href="new-subject.php"><i class="fa fa-plus-square"></i> New subject</a>
            </td>
            <td id="page">
                <?php 
                if (!is_null($sel_subj)) {?>
                    <h2><?php echo $sel_subj['menu_name'];?></h2>
                <?php
                } elseif (!is_null($sel_page)) {?>
                    <h2><?php echo $sel_page['menu_name'];?></h2>
                    <div class="page-content">
                        <?php echo $page_data['content'];?>
                    </div>
                <?php } 
                else {?>
                    <h2>Select a subject or page to edit</h2>
                <?php }?>
                
            </td>
        </tr>
    </table>
<?php include ('includes/footer.php')?>