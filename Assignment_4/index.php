<!-- opening tags and global links -->
<?php require($_SERVER["DOCUMENT_ROOT"]. "~palmerjoshua2013/inc/header.php"); ?>
<!-- custom links -->


<!-- end custom links -->
<?php require($_SERVER["DOCUMENT_ROOT"]."~palmerjoshua2013/inc/mid.php"); ?> 
<!-- body -->

<div class="alert alert-info" role="alert">This page is under construcion (needs styling, but app works).</div>

<div class="jumbotron">
    <h2>Number Converter</h2>
    <p>This Javascript application converts a positive integer's base and shows all the written work.</p>  
</div>

<form>
    <h4>Starting Base</h4>
    <input type="radio" name="Starting Base" value="2">2
    <input type="radio" name="Starting Base" value="8">8
    <input type="radio" name="Starting Base" value="10">10
    <input type="radio" name="Starting Base" value="16">16
    <br>
    <h4>Ending Base</h4>
    <input type="radio" name="Ending Base" value="2">2
    <input type="radio" name="Ending Base" value="8">8
    <input type="radio" name="Ending Base" value="10">10
    <input type="radio" name="Ending Base" value="16">16
    <br>
    <h4>Starting Number</h4>
    <input type="text" name="Starting Number">
    <input type="submit" id="submit" value="Convert">
</form>

<div id="output"></div>
<script type="text/javascript" src="converter.js"></script>


<!-- end body -->
<?php require($_SERVER["DOCUMENT_ROOT"]."~palmerjoshua2013/inc/footer.php"); ?>