<?php
require_once 'header.php';

if (isset($_SESSION['user']))
{
    destroySession();
}
header("Location: http://localhost/Project_2/login.php");
exit;
require_once 'footer.php';
?>