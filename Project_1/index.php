<!-- html, head, and global links (jQuery, Bootstrap) -->
<?php require('../inc/header.php');?>
<!-- custom links -->

<link type="text/css" rel="stylesheet" href="main.css">

<!-- end custom links -->
<?php require('../inc/mid.php');?>
<!-- body -->
<div id="menu"><?php require('../inc/menu.php');?></div>
<div class="container-fluid">
    <div class="row">   
        <div class="col-sm-4">      
            <form>
                
                <div class="form-group">
                    
                    <label for="Headline">Headline</label>
                    <input type="text" class="form-control" id="Headline" placeholder="Headline" required>
                    
                    <label for="TextArea">Text</label>
                    <textarea class="form-control" id="TextArea" style="max-width: 100%; max-height: 76px;" maxlength="140" placeholder="140 characters"></textarea>
                    
                    <label for="ChoosePicture">Upload an Image</label>
                   <input type="file" id="ChoosePicture">
                    
                </div>
                
                <div class="form-group" role="group">
                                      
                    <label for="brightness">Brightness</label>
                    <input type="range" class="slider" id="brightness" value="100" step="1" min="0" max="200">

                    <label for="contrast">Contrast</label>
                    <input type="range" class="slider" id=contrast value="100" step="1" min="0" max="200">

                    <label for="saturate">Saturation</label>
                    <input type="range" class="slider" id="saturate" value="100" step="1" min="0" max="200">
                    
                    <label for="hue-rotate">Hue</label>
                    <input type="range" class="slider" id="hue-rotate" value="0" step="1" min="-360" max="360">
                                         
                    <label for="grayscale">Grayscale</label>
                    <input type="range" class="slider" id="grayscale" value="0" step="1" min="0" max="100">
                    
                    <label for="sepia">Sepia</label>
                    <input type="range" class="slider" id="sepia" value="0" step="1" min="0" max="100">
                                 
                    <label for="invert">Invert</label>
                    <input type="range" class="slider" id="invert" value="0" step="1" min="0" max="100">
                    
                </div>
                <div class="btn-group" role="group" aria-label="...">
                    <button type="reset" class="btn btn-primary" id="Reset">Reset</button>
                    <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                    
                </div>
            </form>      
        </div>
        
        <div class="col-sm-8">
          
            <!-- testing with background image of another page -->
            <img id="output" src="../img/main_background.jpg" alt="img">
            <!-- in main.css ==> width: 100%; height: auto; -->
            <output><h3></h3><p></p></output>
        </div>       
    </div>
</div>

<script src="imgEditor.js"></script>
<!-- end body -->
<?php require('../inc/footer.php');?>
