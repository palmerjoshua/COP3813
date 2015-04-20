<?php
require_once 'header.php';
if(!$loggedin)
{
    header("Location: http://localhost/Project_2/login.php");
    exit;    
}
if(isset($_POST['profiletext']))
{
    updateProfile($_POST['profiletext']);
}

?>

<div class="page-header">
    <h1>Edit Profile</h1>
</div>        

<div class="row">
    <div id="editForm" class="col-sm-4">
        <form id="form" class="form-horizontal" method="POST" action="profile.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="profiletext" class="control-label col-xs-1">Text</label>
                <div class="col-xs-11">
                    <textarea class="form-control" id="profiletext" name="profiletext" maxlength="4096" placeholder="4096 characters" required></textarea>
                </div>
            </div>
            <!--
            <div class="form-group">
                <label for="upload" class="control-label col-xs-8">Choose Profile Picture (optional)</label>
                <img id="image" class="previewimg" name="image" src="/" style="display: none" width="100%">
                <input type="file" id="upload" class="upload col-xs-12" name="upload" accept="image/*">
            </div>
            -->
            <input type="submit" value="Submit" class="btn btn-default">                   
        </form>           
    </div>

    
    <div class="col-sm-8" id="imgFeed">
        <?php echo showProfile(); ?>   
    </div>
</div><!--row-->

<?php require_once 'footer.php'; ?>