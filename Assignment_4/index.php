<!-- opening tags and global links -->
<?php require("../inc/header.php"); ?>
<!-- custom links -->

<link rel="stylesheet" type="text/css" href="main.css">
<title>Converter</title>
<!-- end custom links -->
<?php require("../inc/mid.php"); ?> 

<!-- body -->

<div id="menu">
    <?php require("../inc/menu.php"); ?>
</div>

<div class="jumbotron">
    <h2>Number Converter</h2>
    <p class="text-muted">This application converts a positive integer's radix and shows all the written work.</p>  
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3"></div>
        
        <div class="col-md-3">       
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
                        <label><input type="radio" name="Starting Base" value="10" checked>10</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="Starting Base" value="16">16</label>
                    </div>                                                          
                </div>                         
                <div class="form-group">
                    <label for="[name='Ending Base']">Ending Base</label>                   
                    <div class="radio">
                        <label><input type="radio" name="Ending Base" value="2" checked>2</label>
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
                    <button id="submit" class="btn btn-primary" type="submit">Convert</button>
                </span>
            </div>    
            <br>            
            
            <div class="btn-group" role="group" aria-label="...">
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#appInfo" aria-expanded="false" aria-controls="appInfo" id="dirButton"><span id="buttonText">Directions</span></button>
                <button id="clear" class="btn btn-primary" type="button">Clear</button>    
            
            </div>
            
            
            
            <div class="collapse" id="appInfo">
                <label for="ol[id='directions']"><h4 class="text-primary">Directions</h4></label>
                <ol id="directions">
                    <li><p class="text-primary">Choose the base of the number you want to convert.</p></li>
                    <li><p class="text-primary">Choose the base to which you want to convert the number.</p></li>
                    <li><p class="text-primary">Enter the number you want to convert.</p></li>
                </ol>
                <label for="ol[id='example']"><h4 class="text-primary">Example: Binary to Decimal</h4></label>
                <ol id="example">
                    <li><p class="text-primary">Select Starting Base 2</p></li>
                    <li><p class="text-primary">Select Ending Base 10</p></li>
                    <li><p class="text-primary">Enter a Binary number (e.g. '1101')</p></li>
                    <li><p class="text-primary">Click the 'Convert' button</p></li>               
                </ol>
                
                <label for="p[id='aboutWork']"><h4 class="text-primary">About Work Shown</h4></label>
                <p class="text-primary" id="aboutWork">This application shows the arithmetic used to do these conversions manually.<br><br>The first step is to convert the number into a decimal number -- the type of number with which everyone is most familiar.<br><br>Then it will convert this decimal number into the desired base.<br><br>Of course either of these steps will be omitted if you start or end with a decimal number (no need to convert a decimal number into a decimal number).</p>
                
            </div><!-- appInfo -->    
        </div>        
        
        <div class="col-md-1"></div> <!-- spacer column -->
        <div class="col-md-5"> 
            <output></output>        
        </div>
        

    </div> <!-- row -->   
</div> <!-- container -->
<script type="text/javascript" src="converter.js"></script>

<!-- end body -->
<?php require("../inc/footer.php"); ?>

