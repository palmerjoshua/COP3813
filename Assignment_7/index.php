<?php
require_once "php/db_connect.php";
require_once "php/functions.php";
if(isset($_POST['name']) && isset($_POST['title']) && isset($_POST['text']))
{
    require_once 'submit.php';
}
if(isset($_POST['replyname']) && isset($_POST['replytext']) && isset($_POST['replyparent']))
{
    require_once 'comment.php';
}

if(isset($_POST['adminusername']) && isset($_POST['adminpass']) && isset($_POST['deletestamp']) && isset($_POST['iscomment']))
{
    require_once 'delete.php';
}

?>
<!DOCTYPE html>
<html>
<head>	
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">	
	<title>Jchan</title>	
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/bootstrap-theme.min.css">    
	<link href="http://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <div class="menu">
    <?php require '../inc/menu.php'; ?>
    </div>
	<div class="container">
        <div class="page-header">
            <h1>Submit an Image</h1>
        </div>        
		
        <div class="row">
			<div id="formParent" class="col-sm-3">
				<form id="form" class="form-horizontal" method="POST" action="index.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name" class="control-label col-xs-1">Name</label>
                        <div class="col-xs-11">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-user fa-fw"></span></span>
                                <input type="text" class="form-control" id="name" name="name" 
                            maxlength="20" size="20" value="Anonymous" required placeholder="Name" autofocus>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="title" class="control-label col-xs-1">Title</label>
                        <div class="col-xs-11">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-header fa-fw"></span></span>
                                <input type="text" class="form-control" id="title" name="title" 
                            maxlength="20" size="20" value="" placeholder="optional title" autofocus>
                            </div>
                        </div>
                    </div>
                      
                    <div class="form-group">
                        <label for="text" class="control-label col-xs-1">Text</label>
                        <div class="col-xs-11">
                            <textarea class="form-control" id="text" name="text" maxlength="140" placeholder="140 characters" required></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="upload" class="control-label col-xs-8">Upload Image (optional)</label>
                        <img id="image" class="previewimg" name="image" src="/" style="display: none" width="100%">
                        <input type="file" id="upload" class="upload col-xs-12" name="upload" accept="image/*">
                    </div>                                   
                    
                    <input type="submit" value="Submit" class="btn btn-default">                   
				</form>
			</div><!--form parent-->
            
            <div class="col-sm-1"></div>
            <div class="col-sm-8" id="imgFeed">
                <?php echo getPosts($db); ?>
            </div>
		</div><!--row-->
	</div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>	
	<script src="../js/bootstrap.min.js"></script>	
	<script src="functions.js"></script>
</body>
</html>

<?php $db->close(); ?>