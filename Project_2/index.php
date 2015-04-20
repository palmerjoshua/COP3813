<?php 
require_once('header.php');
if(!$loggedin)
{
    header("Location: http://localhost/Project_2/login.php");
    exit;
}

if(isset($_POST['messagetext']))
{
    submit();
}

?>

<div class="page-header">
    <h1>Main Feed</h1>
</div>        

<div class="row">
    <div id="formParent" class="col-sm-3">
        <form id="form" class="form-horizontal" method="POST" action="index.php" enctype="multipart/form-data">

            <div class="form-group">
                <label for="messagetext" class="control-label col-xs-1">Text</label>
                <div class="col-xs-11">
                    <textarea class="form-control" id="messagetext" name="messagetext" maxlength="140" placeholder="140 characters" required></textarea>
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
        <?php echo getPosts(); ?>
    </div>
</div><!--row-->

<?php require_once('footer.php'); ?>