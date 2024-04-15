<!DOCTYPE html>
<html>
<head>
    <?php
    include ('config/css.php');
    include ('config/js.php');?>
    <title>Widget Corp</title>
</head>
<body>
    
    <div id="header">
        <h1>Widget Corp <?php if($debug['value'] == 1) {?>
            <button id="btn-debug" class="pull-right btn btn-default fa fa-bug"></button>
        <?php }?></h1>
        
    </div>
    <div id="wrap">
        <div id="main">