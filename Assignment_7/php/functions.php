<?php

function sanitizeString($_db, $str)
{
    $str = strip_tags($str);
    $str = htmlentities($str);
    $str = stripslashes($str);
    return mysqli_real_escape_string($_db, $str);
}


function SavePostToDB($_db, $_user, $_title, $_text, $_time, $_file_name)
{
	if (!($stmt = $_db->prepare("INSERT INTO POSTCARDS(USER_USERNAME, STATUS_TITLE, STATUS_TEXT, TIME_STAMP, IMAGE_NAME) VALUES (?, ?, ?, ?, ?)")))
	{
		echo "Prepare failed: (" . $_db->errno . ") " . $_db->error;
	} 
	if (!$stmt->bind_param('sssss', $_user, $_title, $_text, $_time, $_file_name))
	{
		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	if (!$stmt->execute())
	{
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}
    else
    {
        $stmt->close();
    }
}

function saveComment($db, $user, $text, $time, $imgname, $parentTimeStamp)
{
    $query = "INSERT INTO COMMENTS VALUES(?,?,?,?,?)";   
    if(!($stmt=$db->prepare($query)))
    {
        echo "Prepare failed: (" . $db->errno . ") " . $db->error;
    }
    if($imgname != null)
    {
        if(!$stmt->bind_param("sssss", $time, $user, $text, $imgname, $parentTimeStamp))
        {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
    }
    else
    {
        if(!$stmt->bind_param("ssss", $time, $user, $text, $parentTimeStamp))
        {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
    }
    if(!$stmt->execute())
    {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    else
    {
        $stmt->close();
    }  
}


function replyForm($parentTimeStamp)
{
    $form = "<form id='form' class='form-horizontal' method='POST' action='index.php' enctype='multipart/form-data'>";
    
    $form .= "<div class='form-group'>";
    $form .= "<label for='replyname' class='control-label col-xs-1'>Name</label>";
    $form .= "<input type='text' class='form-control' id='replyname' name='replyname' maxlength='20' size='20' value='Anonymous' required autofocus>";
    $form .= "</div>";
    
    $form .= "<div class='form-group'>";
    $form .= "<label for='replytext'>Text</label>";
    $form .= "<textarea class='form-control' id='replytext' name='replytext' maxlength='140' placeholder='140 characters' required></textarea>";
    $form .= "</div>";
    
    $form .= "<div class='form-group'>";
    $form .= "<label class='sr-only' for='replyimage'>Your Image</label>";
    $form .= "<img class='previewimg' name='replyimage' src='/' style='display: none' width='100%'>";
    $form .= "<input type='file' class='upload' name='replyupload' accept='image/*'>";
    $form .= "</div>";
    
    $form .= "<input type='hidden' name='replyparent' value='$parentTimeStamp'>";
    $form .= "<button type='submit' class='btn btn-default'>Submit</button>";                   
    $form .= "</form>";
    return $form;
}

function deleteForm($timestamp, $isComment)
{
    $deleteform = '<form method="POST" action="index.php">';
    $deleteform .= '<input type="text" class="form-control" name="adminusername" placeholder="Username" required>';
    $deleteform .= '<input type="password" class="form-control" placeholder="Password" name="adminpass" required>';
    $deleteform .= '<input type="hidden" class="form-control" name="deletestamp" value="'.$timestamp.'">';
    $deleteform .= '<input type="hidden" class="form-control" name="iscomment" value="' . ($isComment ? '1' : '0') . '">';
    $deleteform .= '<button type="submit" class="btn btn-default">Log In</button></form>';
    return $deleteform;  
}


function getPosts($_db)
{
    $query = "SELECT USER_USERNAME, STATUS_TITLE, STATUS_TEXT, TIME_STAMP, IMAGE_NAME FROM POSTCARDS ORDER BY TIME_STAMP DESC";
    if(!($result = $_db->query($query)))
    {
        die('There was an error fetching posts [' . $_db->error . ']');
    }   
    $output = '';
    while($row = $result->fetch_assoc())
    {
        $title = $row['STATUS_TITLE'];
        $username = $row['USER_USERNAME'];
        $imgname = $row['IMAGE_NAME'];
        $text = $row['STATUS_TEXT'];
        $time = $row['TIME_STAMP'];
        
        $output = $output.'<div class="panel panel-primary"><div class="panel-heading">';
        $output .= $title .' posted by '.$username .'</div>';
        $output .= '<div class="panel-body">';
        $output .= ($imgname == $time.'.jpg')? '<img src="'.'users/'.$imgname.'" width="300px">' : '';
        $output .= '<p>'.$text . '</p><br>';
        $output .=  '<a class="replylink" data-toggle="collapse" href="#reply'.$time.'" aria-expanded="false" aria-controls="replyform">Reply</a>';
        $output .= '<div class="collapse" id="reply'.$time.'"><div class="well">';
        $output .= replyForm($time);    
        $output .= '</div></div>';
        $output .= '<span class="separator"> - </span>';
        $output .=  '<a class="deletelink" data-toggle="collapse" href="#delete'.$time.'" aria-expanded="false" aria-controls="replyform">Delete</a>';
        $output .= '<div class="collapse" id="delete'.$time.'"><div class="well">';
        $output .= '<p class="text-danger">Only administrators can delete.</p>';
        $output .= deleteForm($time, false);    
        $output .= '</div></div>';
        $output .= getComments($_db, $time);
        $output .= "</div></div>";
    }   
    return $output;
}


function getComments($_db, $parentTimeStamp)
{
    $query = "SELECT TIME_STAMP, USERNAME, CONTENT, IMAGE_NAME, PARENT_TS FROM COMMENTS WHERE PARENT_TS='".$parentTimeStamp."' ORDER BY TIME_STAMP ASC";
    if(!($result = $_db->query($query)))
    {
        die('There was an error fetching comments ['.$_db->error.']');
    }
    $output = '';
    while($row = $result->fetch_assoc())
    {
        $username = $row['USERNAME'];
        $text = $row['CONTENT'];
        $time = $row['TIME_STAMP'];
        $imgname = $row['IMAGE_NAME'];
        
        $output = $output . '<div class="panel panel-info"><div class="panel-heading">';
        $output .= $username . " commented:</div>";
        $output .= '<div class="panel-body">';
        $output .= ($imgname == $time.'.jpg') ? '<img src="' . 'users/' . $imgname. '" width="300px">' : '';
        $output .= '<p>'.$text.'</p><br>';
        $output .=  '<a class="deletelink" data-toggle="collapse" href="#delete'.$time.'" aria-expanded="false" aria-controls="replyform">Delete</a>';
        $output .= '<div class="collapse" id="delete'.$time.'"><div class="well">';
        $output .= '<p class="text-danger">Only administrators can delete.</p>';
        $output .= deleteForm($time, true);    
        $output .= '</div></div>';        
        $output .= '</div></div>' ; 
    }
    $result->close();
    return $output;
}
?>