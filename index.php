<?php 
include ('includes/functions.php');
include ('config/setup.php');
include ('includes/header.php');

function get_default_page ($subject_id, $dbc) {
    $page_set = get_pages_for_subject($dbc, $subject_id);
    if ($first_page = mysqli_fetch_array($page_set)) {
        return $first_page;
    } else {
        return NULL;
    }
}

global $sel_page;
global $sel_subj;
if (isset($_GET['subj'])){
    $sel_subj = subjIndex($dbc, $_GET['subj']);
    $name     = "Subject";
    $sel_page = get_default_page($sel_subj['id'], $dbc);
} elseif (isset($_GET['page'])) {
    $sel_page = pagesIndex($dbc, $_GET['page']);
    $name     = "Page";
    $sel_subj = NULL;
} else {
    $sel_page = NULL;
    $name     = NULL;
    $sel_subj = NULL;
}

?>
    <table id="structure">
        <tr>
            <td id="navigation">
                <ul class="subjects list-group">
                    <?php indexData($dbc,'index', 'index');?>
                </ul>
                <br>
                <!--<a class="list-group-item" style="color: blue;" href="new-subject.php"><i class="fa fa-plus-square"></i> New subject</a>-->
            </td>
            <td id="page">
                <?php 
                if (!is_null($sel_subj)) {?>
                <h2><?php echo htmlentities($sel_page['menu_name']);?></h2>
                    <div class="page-content">
                        <?php echo strip_tags($sel_page['content'],"<b><br><i><strong>");?>
                    </div>
                <?php
                } elseif (!is_null($sel_page)) {?>
                    <h2><?php echo $sel_page['menu_name'];?></h2>
                    <div class="page-content">
                        <?php echo $sel_page['content'];?>
                    </div>
                <?php } 
                else {?>
                    <h2>Select a subject or page to edit</h2>
                <?php }?>
                
            </td>
        </tr>
    </table>
<?php include ('includes/footer.php')?>