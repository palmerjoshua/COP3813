<?php 
$startNumber = $output = '';
$thisPage = $_SERVER['PHP_SELF'];

if(isset($_POST['startnumber']) && isset($_POST['startbase']) && isset($_POST['endbase'])){
    $startNumber = sanitize($_POST['startnumber']);
    $output = '<p class="text-primary">Start: ';
    $output .= $startNumber . "    ";
    $output .= "End: "; 
    $output .= base_convert($startNumber, $_POST['startbase'], $_POST['endbase']);
    $output .= "</p>";
}

function sanitize($input){
    return strip_tags(htmlentities(stripslashes($input)));
}

require("../inc/header.php"); //opening HTML and HEAD
echo <<<_END
<link rel="stylesheet" type="text/css" href="main.css">
<title>Converter</title>
_END;

require("../inc/mid.php"); // closing HEAD, opening BODY


echo '<div id="menu">';
require("../inc/menu.php"); // reusable menu bar
echo <<<_END
</div>

<div class="container-fluid">
    <div class="jumbotron">
        <h2>Number Converter</h2>
        <p class="text-muted">This application converts a positive integer's radix using PHP.</p>  
    </div>
    <div class="row">
        <div class="col-md-2"></div>
        
        <div class="col-md-3" id="inputdiv">       
            <form class="form-inline" role="form" action="$thisPage" method="post">
                <div class="form-group">                  
                    <label for="[name='startbase']">Starting Base</label>
                    <div class="radio">
                        <label><input type="radio" name="startbase" value="2">2</label>                       
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="startbase" value="8">8</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="startbase" value="10" checked>10</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="startbase" value="16">16</label>
                    </div>                                                          
                </div>                         
                <div class="form-group">
                    <label for="[name='endbase']">Ending Base</label>                   
                    <div class="radio">
                        <label><input type="radio" name="endbase" value="2" checked>2</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="endbase" value="8">8</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="endbase" value="10">10</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="endbase" value="16">16</label>
                    </div>                                                                      
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" name="startnumber" placeholder="Starting Number">                   
                    <button id="submit" class="btn btn-primary" type="submit">Convert</button>                
                </div>
            </form>                                       
        </div>                
        <div class="col-md-2"></div>
        <div class="col-md-3" id="outputdiv"> 
            <output>$output</output>        
        </div>
        <div class="col-md-2"></div>
    </div> <!-- row -->   
</div> <!-- container -->
<script type=text/javascript src="converter.js"></script>
<!-- All this does is change the class on the navbar -->

_END;
require("../inc/footer.php"); // end BODY and HTML
?>


