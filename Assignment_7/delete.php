<?php 
$username = sanitizeString($db, $_POST['adminusername']);
$password = sanitizeString($db, $_POST['adminpass']);
$deletestamp = sanitizeString($db, $_POST['deletestamp']);
$isComment = sanitizeString($db, $_POST['iscomment']);

$query = "SELECT name, pass FROM admin WHERE id=1";
if(!($result=$db->query($query)))
{
    die($db->error);
}
$valid = false;
while($row=$result->fetch_assoc())
{
    $valid = ($username==$row['name'] && $password==$row['pass']);
}
if($valid)
{
    deleteFromFolder($db, $deletestamp, ($isComment=='1'));
    deleteFromDB($db, $deletestamp, ($isComment=='1'));
}

function deleteFetch($db, $query, $timestamp)
{
    if(!($stmt=$db->prepare($query)))
    {
        die($db->error);
    }
    if(!$stmt->bind_param("s", $timestamp))
    {
        die($stmt->error); 
    }
    if(!$stmt->execute())
    {
        die($stmt->error); 
    }
    if(!$stmt->bind_result($result))
    {
        die($stmt->error); 
    }
    while($stmt->fetch())
    {
        unlink('users/'.$result);
    }
}


function deleteFromFolder($db, $timestamp, $isComment)
{
    $query = "SELECT image_name FROM `COMMENTS` WHERE ". ($isComment ? "time_stamp" : "parent_ts") . "=? AND image_name LIKE '%jpg'";
    deleteFetch($db, $query, $timestamp);
    if(!$isComment)
    {
        $query = "SELECT image_name FROM `POSTCARDS` WHERE time_stamp=? AND image_name LIKE '%jpg'";
        deleteFetch($db, $query, $timestamp);
    }   
}

function deleteFromDB($db, $timestamp, $isComment)
{  
    $query = "DELETE FROM `COMMENTS` WHERE " . ($isComment ? "TIME_STAMP" : "PARENT_TS") . "=?";
    if(!($stmt=$db->prepare($query)))
    {
        die($db->error);
    }
    if(!$stmt->bind_param("s", $timestamp))
    {
        echo "Cannot bind param for delete.";
    }
    if(!$stmt->execute())
    {
        echo "Cannot execute for delete.";
    }
    if(!$isComment)
    {
        $query = "DELETE FROM `POSTCARDS` WHERE TIME_STAMP=?";
        if(!($stmt=$db->prepare($query)))
        {
            echo "Cannot prepare statement for delete.";
        }
        if(!$stmt->bind_param("s", $timestamp))
        {
            echo "Cannot bind param for delete.";
        }
        if(!$stmt->execute())
        {
            echo "Cannot execute for delete.";
        }       
    }
}    
?>