<?php require('../inc/header.php'); ?>
<!-- custom links -->
<link rel="stylesheet" type="text/css" href="main.css">
<!-- end custom links -->
<?php require('../inc/mid.php'); ?>
<!-- body -->
<div id="menu"><?php require("../inc/menu.php");?></div>
<div class="col-sm-4"></div>

<div class="col-sm-4" id="listDiv">
    <div class="list-group"></div>
    <button type="button" class="btn btn-block btn-default" id="mainButton">
        <span class="glyphicon glyphicon-plus"></span>
    </button>
</div>

<div class="col-sm-4"></div>
<script type="text/javascript" src="toDo.js"></script>
<!-- end body -->
<?php require('../inc/footer.php'); ?>