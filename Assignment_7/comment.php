<?php
$name = sanitizeString($db, $_POST['replyname']);
$parentstamp = sanitizeString($db, $_POST['replyparent']);
$text = sanitizeString($db, $_POST['replytext']);   
$time = $_SERVER['REQUEST_TIME'];
if ($_FILES)
{
    $fileUploaded = !empty($_FILES) && file_exists($_FILES['replyupload']['tmp_name']) && is_uploaded_file($_FILES['replyupload']['tmp_name']);
    $imgname = $time . ($fileUploaded? '.jpg' :'NOPIC');
    $dstFolder = $fileUploaded? 'users' :null;
    if($fileUploaded)
    {
        move_uploaded_file($_FILES['replyupload']['tmp_name'], $dstFolder . DIRECTORY_SEPARATOR . $imgname);
    }
}
saveComment($db, $name, $text, $time, $imgname, $parentstamp);
unset($_POST['replyname']);
unset($_POST['replytext']);
unset($_POST['replyparent']);
?>