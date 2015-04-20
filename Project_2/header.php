<?php // Example 26-2: header.php
session_start();
require_once 'functions.php';
$userstr = ' (Guest)';
$loggedin = false;
if (isset($_SESSION['user']) && isset($_SESSION['uid']))
{
    $USER     = $_SESSION['user'];
    $UID      = $_SESSION['uid'];
    $loggedin = true;
    $userstr  = " ($USER)";
}
echo <<<_END
<!DOCTYPE html>
<html>
<head>
    <link rel='stylesheet' href='styles.css' type='text/css'>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-theme.min.css">
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script src='javascript.js'></script>\n
_END;
if ($loggedin)
{
    echo <<<_END
    <div class='container'>
        <ul class='nav nav-pills'>
            <li role='presentation'><a href='index.php'>Home</a></li>
            <li role='presentation'><a href='members.php'>Members</a></li>         
            <li role='presentation'><a href='friends.php'>Friends</a></li>         
            <li role='presentation'><a href='messages.php'>Messages</a></li>       
            <li role='presentation'><a href='profile.php'>Edit Profile</a></li>    
            <li role='presentation'><a href='logout.php'>Log out</a></li>
        </ul>\n
_END;
}
else
{
    echo <<<_END
    <div class='container'>
        <ul class='nav nav-pills'>         
            <li role='presentation'><a href='signup.php'>Sign up</a></li>
            <li role='presentation'><a href='login.php'>Log in</a></li>
        </ul>\n
_END;
}
?>