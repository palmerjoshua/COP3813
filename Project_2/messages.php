<?php 
require_once 'header.php';
if(!$loggedin)
{
    header("Location: http://localhost/Project_2/login.php");
    exit;
}
$header = "Messages ";
if(isset($_GET['u']))
{
    $uname = sanitizeString($_GET['u']);
    $smallColumn = messageForm($uname);
    $bigColumn = getPosts($uname, 1);
    $header .= "<small><a class='small' href='messages.php'>back</a></small>";
    
}
else
{
    $smallColumn = messageList();
    $bigColumn = getPosts($pm=1);
}

if(isset($_POST['messagetext']))
{
    submit($uname,1);
    $bigColumn = getPosts($uname, 1);
}

?>

<div class="page-header">
    <h1><?php echo $header; ?></h1>
</div>        

<div class="row">
    <div id="listParent" class="col-sm-4">
       <?php echo $smallColumn; ?>    
    </div>

    
    <div class="col-sm-8" id="imgFeed">
        <?php echo $bigColumn; ?>
    </div>
</div><!--row-->


<?php require_once 'footer.php'; ?>