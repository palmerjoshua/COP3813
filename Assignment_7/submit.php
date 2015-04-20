<?php   
$name = sanitizeString($db, $_POST['name']);
$title = sanitizeString($db, $_POST['title']);
$text = sanitizeString($db, $_POST['text']);   
$time = $_SERVER['REQUEST_TIME'];
$title = ($title=='')?$time:$title;
if ($_FILES)
{
    $fileUploaded = !empty($_FILES) && file_exists($_FILES['upload']['tmp_name']) && is_uploaded_file($_FILES['upload']['tmp_name']);
    $imgname =  $time . ($fileUploaded? '.jpg' :'NOPIC');
    $dstFolder = $fileUploaded? 'users' :null;
    if($fileUploaded)
    {
        move_uploaded_file($_FILES['upload']['tmp_name'], $dstFolder . DIRECTORY_SEPARATOR . $imgname);
    }
}
SavePostToDB($db, $name, $title, $text, $time, $imgname);
unset($_POST['name']);
unset($_POST['text']);
unset($_POST['title']);
?>
