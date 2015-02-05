<!-- opening tags and global links -->
<?php require("../inc/header.php"); ?>
<!-- custom links -->


<!-- end custom links -->
<?php require("../inc/mid.php"); ?> 
<!-- body -->

<div id="menu">
    <?php require("../inc/menu.php"); ?>
</div>

<div class="alert alert-info" role="alert">This page is under construcion (needs styling, but app works).</div>

<div class="jumbotron">
    <h2>Number Converter</h2>
    <p class="text-muted">This Javascript application converts a positive integer's base and shows all the written work.</p>  
</div>


<div class="container-fluid">

    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-4">
        
            <form class="form-inline" role="form">
                <div class="form-group">
                    
                    <label for="[name='Starting Base']">Starting Base</label>
                    <div class="radio">
                        <label><input type="radio" name="Starting Base" value="2">2</label>                       
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="Starting Base" value="8">8</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="Starting Base" value="10">10</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="Starting Base" value="16">16</label>
                    </div>                                                          
                </div>
                          
                <div class="form-group">
                    <label for="[name='Ending Base']">Ending Base</label>                   
                    <div class="radio">
                        <label><input type="radio" name="Ending Base" value="2">2</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="Ending Base" value="8">8</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="Ending Base" value="10">10</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="Ending Base" value="16">16</label>
                    </div>                                                                      
                </div>
            </form>
            <div class="input-group">
                <input type="text" class="form-control" name="Starting Number" placeholder="Starting Number">
                <span class="input-group-btn">
                    <button id="submit" class="btn btn-default" type="submit">Convert</button>
                </span>
            </div>    
        
        </div>
        <div class="col-md-4">
            <output></output>
        </div>
        <div class="col-md-2"></div>
    </div>
    

</div>

<div id="output"></div>
<script type="text/javascript" src="converter.js"></script>


<!-- end body -->
<?php require("../inc/footer.php"); ?>