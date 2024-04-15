<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="css/bootstrap.min.css">
<!--<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">-->

<!-- Optional theme -->
<link rel="stylesheet" href="css/bootstrap-theme.min.css">
<!--<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">-->

<!-- jQuery CSS -->
<link rel="stylesheet" href="js/jquery-ui-1.12.0/jquery-ui.css">
<!--<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smothness/jquery-ui.css">-->

<!-- FontAwesome -->
<link rel="stylesheet" href="css/fontawesome-free-5.1.0-web/css/all.css">
<!--<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">-->

<style>
    
    /*Site colord:
    #1A446C - blue grey
    #689DC1 - light blue
    #D4E6F4 - very light blue
    #EEE489 - light tan
    #8D0D19 - burgundy
    */
    
    html {
        height: 100%;
        width: 100%;
    }
    body {
        width: 100%;
        height: 100%;
        margin: 0px;
        padding: 0px;
        border: 0px;
        font-family: Verdana, Arial, Helvetica, sans-serif;
        background: #D4E6F4;
        font-size: 13px;
        line-height: 15px;
    }
    img {
        border: none;
    }
    table, tr, td {
        border-collapse: collapse;
        vertical-align: top;
        font-size: 13px;
        line-height: 15px;
    }
    a {
        color: #8D0D19;
    }
    #header {
        height: 70px;
        margin: 0px;
        padding: 0px;
        text-align: left;
        background: #1A446C;
        color: #D4E6F4;
    }
    #header h1 {
        padding: 10px;
        margin: 0px;
    }
    #main {
        margin: 0px;
        padding: 0px;
        height: 600px;
        width: 100%;
        background: #EEE489;
    }
    #structure {
        height: 600px;
        width: 100%;
    }
    #footer {
        height: 60px;
        margin: 0px;
        padding: 2em;
        text-align: center;
        background-color: #F5F5F5;
    }
    
    /*Navigation*/
    #navigation {
        width: 20%;
        padding: 1em 1.5em;
        /*color: #D4E6F4;*/
        background: #F5F5F5;
    }
    #navigation a {
        color: #D4E6F4;
        text-decoration: none;
    }
    ul .subjects {
        padding-left: 0;color: black;
        list-style: none;
    }
    ul .pages {
        padding-left: 2em;
        list-style: square;
    }
    .selected {
        font-weight: bold;
    }
    
    /*Page Content*/
    #page {
        width: 80%;
        padding-left: 2em;
        vertical-align: top;
        background: white;
    }
    #page h2 {
        color: #8D0D19;
        margin-top: 1em;
    }
    #page h3 {
        color: #8D0D19
    }
    
    #console-debug {
        position: absolute;
        top: 52px;
        left: 0px;
        width: 30%;
        height: 500px;
        overflow-y: scroll;
        background: #ffffff;
        box-shadow: 2px 2px 5px #cccccc;
    }
    
</style>