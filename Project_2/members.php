<?php 
require_once('header.php');
if(!$loggedin)
{
    header("Location: http://localhost/Project_2/login.php");
    exit;
}

if(isset($_GET['user']))
{
    $usr = sanitizeString($_GET['user']);
    $bigColumn = getPosts($usr);
    $smallColumn = showProfile($usr);
    $header = ($usr!=$USER) ? $usr."'s profile " : "your profile ";
    $header .= ($usr!=$USER) ? "<small><a class='small' href='messages.php?u=$usr'>message</a>"
        : '<small>';
    $header .= "<span class='small'> | </span>";
    $header .= "<a class='small' href='members.php'>back</a></small>";
}
else
{
    $bigColumn = '';
    $smallColumn = memberList();
    $header = "Members";
}

?>

<div class="page-header">
    <h2><?php echo $header; ?></h2>
</div>        

<div class="row">
    <div id="listParent" class="col-sm-4">
       <?php echo $smallColumn; ?>    
    </div>

    
    <div class="col-sm-8" id="imgFeed">
        <?php echo $bigColumn; ?>
    </div>
</div><!--row-->

<?php require_once('footer.php'); ?>