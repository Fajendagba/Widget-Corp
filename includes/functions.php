<?php

function subjectContent($dbc) {
    $q = "SELECT * FROM subjects ORDER BY position ASC";
    $r = mysqli_query($dbc, $q);
    
    if (!r) {
        die ("Database Failed<br>". mysqli_error($dbc));
    }
    return $r;
}

function pageContent($dbc) {
    $q = "SELECT * FROM pages ORDER BY position ASC";
    $r = mysqli_query($dbc, $q);
    
    if (!r) {
        die ("Database Failed<br>". mysqli_error($dbc));
    }
    return $r;     
}

function pagesContent($dbc, $id) {
    $q = "SELECT * FROM pages WHERE id=$id ORDER BY position ASC";
    $r = mysqli_query($dbc, $q);
    
    if (!r) {
        die ("Database Failed<br>". mysqli_error($dbc));
    }
    return $r; 
}

function get_pages_for_subject($dbc, $id) {
    $q = "SELECT * FROM pages WHERE subject_id=$id";
    $r = mysqli_query($dbc, $q);
    
    if (!r) {
        die ("Database Failed<br>". mysqli_error($dbc));
    }
    return $r; 
}

function subjContent($dbc, $id) {
    $q = "SELECT * FROM subjects WHERE id=$id ORDER BY position ASC";
    $r = mysqli_query($dbc, $q);
    
    if (!r) {
        die ("Database Failed<br>". mysqli_error($dbc));
    }
    if ($data = mysqli_fetch_assoc($r)){
        return $data;
    } else {
        return NULL;
    }    
}

function subjIndex($dbc, $id) {
    $q = "SELECT * FROM subjects WHERE slug='$id' ORDER BY position ASC";
    $r = mysqli_query($dbc, $q);
    
    if (!r) {
        die ("Database Failed<br>". mysqli_error($dbc));
    }
    if ($data = mysqli_fetch_assoc($r)){
        return $data;
    } else {
        return NULL;
    }
}

function pagesIndex($dbc, $id) {
    $q = "SELECT * FROM pages WHERE slug='$id' && visible=1 ORDER BY position ASC";
    $r = mysqli_query($dbc, $q);
    
    if (!r) {
        die ("Database Failed<br>". mysqli_error($dbc));
    }
    if ($data = mysqli_fetch_assoc($r)){
        return $data;
    } else {
        return NULL;
    }  
}

function sanitizeString($var)
{
    global $dbc;
    $var = strip_tags($var,"<b><br><i><strong>");
//    $var = htmlentities($var);
    $var = stripcslashes($var);
    return $dbc->real_escape_string($var);
}

function mysql_prep($value) {
    $magic_quotes_active = get_magic_quotes_gpc();
    $new_enough_php = function_exists("mysqli_real_escape_string");
    
    if ($new_enough_php) {
        if ($magic_quotes_active) {
            $value = stripslashes($value);
        }
        $value = mysqli_real_escape_string($value);
    } else {
        if (!$magic_quotes_active) {
            $value = addslashes($value);
        }
    }
    return $value;
}

//function selected ($val1, $val2, $return) {
//    if ($val1 == $val2) {
//        echo "$return";
//    }
//}

function find_selected_page($dbc) {
    global $sel_page;
    global $sel_subj;
    if (isset($_GET['subj'])){
        $sel_subj = subjContent($dbc, $_GET['subj']);
        $sel_page = NULL;
    } elseif (isset($_GET['page'])) {
        $sel_page = pagesContent($dbc, $_GET['page']);
        $sel_subj = NULL;
    } else {
        $sel_page = NULL;
        $name     = NULL;
        $sel_subj = NULL;
    }
}

function subjectData($dbc) {
    $q = "SELECT * FROM subjects ORDER BY position ASC";
    $subject_set = mysqli_query($dbc, $q);

    if (!$subject_set) {
        die ("Database Failed<br>". mysqli_error($dbc));
    }
    while ($subject = mysqli_fetch_assoc($subject_set)) {?>
        <li class="list-group-item <?php if($subject['id'] == $_GET['subj']){ echo "active"; }?>">             
            <a <?php if($subject['id'] == $_GET['subj']){echo ' style="color:white"';}?> style="color:blue;" href="edit_subject.php?subj=<?php echo $subject['id']?>"><?php echo $subject['menu_name'].' ';?></a>
            <i style="color: goldenrod;" class="fa fa-chevron-circle-down pull-right" 
               data-toggle="collapse" data-target="#pages_<?php echo $subject['id']?>"></i>
        </li>
        
        <?php
        $q = "SELECT * FROM pages WHERE visible=1&&subject_id={$subject['id']} ORDER BY position ASC";
        $page_set = mysqli_query($dbc, $q);
        
        if (!$page_set) {
            die ("Database Failed<br>". mysqli_error($dbc));
        }?>
        <ul class="pages collapse" id="pages_<?php echo $subject['id']?>">
        <?php while ($page = mysqli_fetch_assoc($page_set)) {?>
            <li class="list-group-item <?php if($page['id'] == $_GET['page']){ echo "active"; }?>">
                <a <?php if($page['id'] == $_GET['page']){echo ' style="color:white"';}?> style="color:blue;" href="edit_page.php?page=<?php echo $page['id']?>"><?php echo $page['menu_name'].' ';?></a>
            </li>
        <?php }?>
        </ul>
    <?php }
}

function indexData($dbc, $su, $pa) {
    $q = "SELECT * FROM subjects WHERE visible=1 ORDER BY position ASC";
    $subject_set = mysqli_query($dbc, $q);

    if (!$subject_set) {
        die ("Database Failed<br>". mysqli_error($dbc));
    }
    while ($subject = mysqli_fetch_assoc($subject_set)) {?>
        <li class="list-group-item <?php if($subject['slug'] == $_GET['subj']){ echo "active"; }?>">             
            <a <?php if($subject['slug'] == $_GET['subj']){echo ' style="color:white"';}?> style="color:blue;" href="<?php echo $su;?>.php?subj=<?php echo $subject['slug']?>"><?php echo $subject['menu_name'].' ';?></a>
            <i style="color: goldenrod;" class="fa fa-chevron-circle-down pull-right" data-toggle="collapse" data-target="#pages_<?php echo $subject['id']?>"></i>
        </li>
        
        <?php
        $q = "SELECT * FROM pages WHERE visible=1&&subject_id={$subject['id']} ORDER BY position ASC";
        $page_set = mysqli_query($dbc, $q);
        
        if (!$page_set) {
            die ("Database Failed<br>". mysqli_error($dbc));
        }?>
        <ul class="pages collapse" id="pages_<?php echo $subject['id']?>">
        <?php while ($page = mysqli_fetch_assoc($page_set)) {?>
            <li class="list-group-item <?php if($page['slug'] == $_GET['page']){ echo "active"; }?>">
                <a <?php if($page['slug'] == $_GET['page']){echo ' style="color:white"';}?> style="color:blue;" href="<?php echo $pa;?>.php?page=<?php echo $page['slug']?>"><?php echo $page['menu_name'].' ';?></a>
            </li>
        <?php }?>
        </ul>
    <?php }
}

function data_settings_value($dbc, $id) {
    $q = "SELECT * FROM settings WHERE id = '$id'";
    $r = mysqli_query($dbc, $q);
    $data = mysqli_fetch_assoc($r);
	
    return $data;
}

function redirect_to($location = NULL) {
    if ($location != NULL) {
        header("location: {$location}");
        exit();
    }
}

?>
