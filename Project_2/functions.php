<?php // Example 26-1: functions.php
  $dbhost  = 'localhost';    // Unlikely to require changing
  $dbname  = 'joshsnest';   // Modify these...
  $dbuser  = '';   // ...variables according
  $dbpass  = '';   // ...to your installation
  $appname = "JoshSpace"; // ...and preference
  $connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
  if($connection->connect_error) 
  {
      die($connection->connect_error);
  }
date_default_timezone_set('EST');

function queryMysql($query, $params=null, $typestring=null)
{
    global $connection;    
    if($params==null && $typestring==null)
    {
        $result = $connection->query($query);
        if (!$result) die($connection->error);
    }
    else if($params!=null && $typestring!=null)
    {
        if(!($result=$connection->prepare($query)))
        {
            die('[PREPARE] '.$connection->error);
        }        
        if(!call_user_func_array(array($result, 'bind_param'), array_merge(array($typestring), $params)))
        {
            die('[BIND_PARAM] '.$result->error);
        }       
        if(!$result->execute())
        {
            die('[EXECUTE] '.$result->error);
        }
    }
    else
    {
        die('[queryMysql] wrong number of parameters');
    }
    return $result;
}

function destroySession()
{
    unset($_SESSION);
    if (session_id() != "" || isset($_COOKIE[session_name()]))
    {
        setcookie(session_name(), '', time()-2592000, '/');
    }
    session_destroy();
}

function sanitizeString($var)
{
    global $connection;
    $var = strip_tags($var);
    $var = htmlentities($var);
    $var = stripslashes($var);
    return $connection->real_escape_string($var);
}

function randomString($length=8)
{
    $string = 'abcdefghijklmnopqrstuvwxyz'.
              'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.
              '0123456789';
    return substr(str_shuffle($string),0,$length);
}

function showProfile($user=null)
{
    global $USER, $UID;
    $user = ($user)? $user : $USER;
    $query = "SELECT text FROM profiles WHERE uid=";
    $query .= ($user) ? "(SELECT uid FROM users WHERE uname=?)" : "?";
    $params = ($user) ? array(&$user) : array(&$UID);
    $typstr = ($user) ? 's' : 'i';
    $result = queryMysql($query, $params, $typstr);
    $result->bind_result($ptext);
    if(!$result->fetch())
    {
        $ptext = "No profile information.";
    }
    $result->close();
    return $ptext;
}

function updateProfile($text)
{
    global $UID;
    $text = sanitizeString($text);
    $query = "SELECT uid FROM profiles WHERE uid=?";
    $params = array(&$UID);
    $result = queryMysql($query, $params, 'i');
    if($result->fetch())
    {
        $query = "UPDATE profiles SET text=? WHERE uid=?";
    }
    else
    {   
        $idQuery = "(SELECT uid FROM users WHERE uid=?)";
        $query = "INSERT INTO profiles VALUES (?, $idQuery)";
    }
    $result->close();
    $params = array(&$text, &$UID);
    queryMysql($query, $params, 'si')->close();
}


function messageForm($user)
{
    return <<<_END
    <form method='post' action='messages.php?u=$user'>
        <div class='form-group'>
            <label for='messagetext'>Leave a private message:</label>
            <textarea class='form-control' id='messagetext' name='messagetext' rows='3'></textarea>
        </div>
        <input type='submit' class='btn btn-primary' value='Send'>
    </form>
_END;
}

function signUpForm()
{
    echo <<<_END
    <form method='post' action='signup.php'>  
        <div class='form-group'>
            <label for='user'>Username</label>
            <input type='text' class='form-control' maxlength='16' name='user' placeholder='new username' required autofocus>
        </div>
        <div class='form-group'>
            <label for='pass'>Password</label>
            <input type='password' class='form-control' maxlength='16' name='pass' placeholder='new password' required>
        </div>
        <input type='submit' class='btn btn-default' value='Sign up'>
    </form>
_END;
}

function logInForm()
{
echo <<<_END
    <form method='post' action='login.php'>  
        <div class='form-group'>
            <label for='user'>Username</label>
            <input type='text' class='form-control' maxlength='16' name='user' placeholder='enter your username' required autofocus>
        </div>
        <div class='form-group'>
            <label for='pass'>Password</label>
            <input type='password' class='form-control' maxlength='16' name='pass' placeholder='enter your password' required>
        </div>
        <input type='submit' class='btn btn-default' value='Login'>
    </form>
_END;
}

function memberList()
{
    $memberList = '<ul class="list-group">';    
    $result = queryMysql('SELECT uname FROM users ORDER BY uname');
    while($row = $result->fetch_row())
    {
        //if($row[0] == $USER) continue;
        $memberList .= "<li class='list-group-item'><a href=members.php?user=$row[0]>$row[0]</a></li>";
    }
    $memberList .= '</ul>';
    return $memberList;
}


function submit($recipient=null, $pm=0)//without passing parameter, make self post
{
    global $USER, $UID;
    $fileUploaded = !empty($_FILES) && file_exists($_FILES['upload']['tmp_name']) && is_uploaded_file($_FILES['upload']['tmp_name']);
    if($fileUploaded)
    {      
        $imgname = randomString();
        $saveto = getcwd().DIRECTORY_SEPARATOR."users".DIRECTORY_SEPARATOR.$USER.DIRECTORY_SEPARATOR.$imgname;
        move_uploaded_file($_FILES['upload']['tmp_name'], $saveto);
        $typeok = true;
        switch($_FILES['upload']['type'])
        {
          case "image/gif":   $src = imagecreatefromgif($saveto); break;
          case "image/jpeg":  // Both regular and progressive jpegs
          case "image/pjpeg": $src = imagecreatefromjpeg($saveto); break;
          case "image/png":   $src = imagecreatefrompng($saveto); break;
          default:            $typeok = false; break;
        }
        if ($typeok)
        {
            list($w, $h) = getimagesize($saveto);
            $max = 100;
            $tw  = $w;
            $th  = $h;
            if ($w > $h && $max < $w)
            {
                $th = $max / $w * $h;
                $tw = $max;
            }
            elseif ($h > $w && $max < $h)
            {
                $tw = $max / $h * $w;
                $th = $max;
            }
            elseif ($max < $w)
            {
                $tw = $th = $max;
            }
            $tmp = imagecreatetruecolor($tw, $th);
            imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
            imageconvolution($tmp, array(array(-1, -1, -1),
            array(-1, 16, -1), array(-1, -1, -1)), 8, 0);
            imagejpeg($tmp, $saveto);
            imagedestroy($tmp);
            imagedestroy($src);
        }
        $selectQuery = '(SELECT uid FROM users WHERE uid=?)';
        $query = "INSERT INTO images (iname, uid) VALUES (?,$selectQuery)";
        $params = array(&$imgname, &$UID);
        queryMysql($query, $params, 'si')->close();
        $query = "SELECT iid FROM images WHERE iname=?";
        $params = array(&$imgname);
        $result=queryMysql($query, $params, 's');
        $result->bind_result($iname);
        if(!$result->fetch())
        {
            $iname=null;
            echo "CANT GET IMAGE NAME FROM DB";
        }
        $result->close();
    }// if file uploaded...
    else
    {
        $iname = null;
    }
    $uQuery = '(SELECT uid FROM users WHERE uname=?)';
    $iQuery = '(SELECT iid FROM images WHERE iname=?)';
    $query = "INSERT INTO MESSAGES (text, time, pm, aid, rid, iid) VALUES (?,?,?,$uQuery,$uQuery,$iQuery)";
    $text = sanitizeString($_POST['messagetext']);
    $auth = sanitizeString($USER);
    $recp = ($recipient!=null) ? sanitizeString($recipient) : $auth;
    $time = $_SERVER['REQUEST_TIME'];
    $typestring = "ssisss";
    $params = array(&$text, &$time, &$pm, &$auth, &$recp, &$iname);
    queryMysql($query, $params, $typestring)->close();
    
}

function getPosts($uname=null, $pm=0)
{
    $idQuery = "(SELECT u.uid FROM users u WHERE u.uname=?)";
    global $UID, $USER;
    if($uname==null)
    {// all posts
        $query  = "SELECT m.text, m.time, u1.uname, u2.uname ";
        $query .= "FROM messages m ";
        $query .= "JOIN users u1 ON u1.uid=m.aid ";
        $query .= "JOIN users u2 on u2.uid=m.rid ";
        $query .= "WHERE m.pm=? ORDER BY m.time DESC";
        $params = array(&$pm);
        $typestring = "i";
    }
    else if($pm==0)
    {// user's posts
        $query  = "SELECT m.text, m.time, u1.uname ";
        $query .= "FROM messages m ";
        $query .= "JOIN users u1 on u1.uid=m.aid ";
        $query .= "WHERE m.pm=0 ";
        $query .= "AND m.rid=$idQuery ORDER BY m.time DESC";
        $params = array(&$uname);
        $typestring = "s";
    }
    else
    {
        $query = <<<_END
(SELECT text, time, u1.uname, u2.uname
FROM messages
JOIN users u1 ON (u1.uid=messages.aid)
JOIN users u2 ON (u2.uid=messages.rid)
WHERE (u1.uid=? AND u2.uid=$idQuery)
AND pm=1)
UNION
(SELECT text, time, u3.uname, u4.uname
FROM messages
JOIN users u3 ON (u3.uid=messages.aid)
JOIN users u4 ON (u4.uid=messages.rid)
WHERE (u3.uid=$idQuery AND u4.uid=?)
AND pm=1)
ORDER BY time DESC;
_END;
        $params = array(&$UID, &$uname, &$uname, &$UID);
        $typestring = "issi";
    }
    $stmt = queryMysql($query, $params, $typestring);
    $result = $stmt->get_result();
    $output = '';
    while($row = $result->fetch_row())
    {
        $text = $row[0];
        $time = $row[1];
        $auth = $row[2];
        $recp = ($uname==null) ? $row[3] : $uname;
        $headingText = date('F j, Y, g:i a', $time);
        if($pm==0)
        {
        $headingText .= ($auth==$recp) ? " $auth posted: " : " $auth ==> $recp: ";
        }
        else
        {
            $headingText .= ($auth!=$USER) ? ' '.$auth : ' You';
            $headingText .= " posted:";
            
        }
        
        $output .= <<<_END
            <div class='panel panel-primary'>
                <div class='panel-heading'>
                    $headingText
                </div>
                <div class='panel-body'>
                    $text
                </div>
            </div>\n
_END;

    }
    $stmt->close();
    return $output;
}

function messageList()
{
    global $UID, $USER;
    $query = "SELECT DISTINCT u.uname ".
             "FROM users u ".
             "JOIN messages m ".
             "ON (u.uid=m.rid OR u.uid=m.aid) ".
             "WHERE m.rid!=m.aid ".
             "AND (m.rid=? OR m.aid=?) ".
             "AND pm=1 ORDER BY u.uname";
    $params = array(&$UID, &$UID);
    $result = queryMysql($query, $params, 'ii');
    $result->bind_result($name);
    
    $output = "<ul class='list-group'>";
    while($result->fetch())
    {
        if($name==$USER) continue;
        $output .= "<li class='list-group-item'>".
                  "<a href='messages.php?u=$name'>$name</a>".
                  "</li>";
    }
    $output .= "</ul>";
    $result->close();
    return $output;
}


?>