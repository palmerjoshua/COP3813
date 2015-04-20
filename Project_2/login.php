<?php 
require_once('header.php');
$error = '';
if(isset($_POST['user']) && isset($_POST['pass']))
{
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);
    $query = "SELECT * FROM users WHERE uname=? AND pass=?";
    $params = array(&$user, &$pass);
    $result = queryMySQL($query, $params, 'ss');
    $result->bind_result($uid,$user, $pass);  
    if (!$result->fetch())
    {
        $error = "<p class='text-danger'>Username and/or Password invalid</p>";
        $result->close();
    }
    else
    {
        $_SESSION['user'] = $user;
        $_SESSION['uid'] = $uid;
        $result->close();
        header("Location: http://localhost/Project_2/");
        exit;
    }
}
echo $error;
logInForm();
require_once('footer.php');
?>