<?php 
require_once('header.php');

if($loggedin)
{
    destroySession();
}
$error = '';
if(isset($_POST['user']) && isset($_POST['pass']))
{
    
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);
    $query = "SELECT uname FROM users WHERE uname=?";
    $params = array(&$user);
    $result = queryMysql($query, $params, 's');
    $result->bind_result($exists);
    if ($result->fetch())
    {
        $error = "<p class='text-danger'>That username already exists.</p>";
        $result->close();
    }
    else
    {
        $result->close();
        $query = "INSERT INTO users (uname,pass) VALUES(?,?)";
        $params[] = &$pass;
        queryMysql($query, $params, 'ss')->close();
        mkdir('users/'.$user);
        header("Location: http://localhost/Project_2/login.php");
        exit;
    }
}
echo $error;
signUpForm();
require_once('footer.php');
?>