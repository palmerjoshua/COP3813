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
                    <input type="text" class="form-control" id="Headline" placeholder="Headline" maxlength="25" required>
                    
                    <label for="TextArea">Text</label>
                    <textarea class="form-control" id="TextArea" style="max-width: 100%; max-height: 76px;" maxlength="140" placeholder="140 characters"></textarea>
                    
                    <label for="ChoosePicture">Upload an Image</label>
                   <input type="file" id="ChoosePicture">
                    
                </div>
                                   
                <div class="btn-group" role="group" aria-label="...">
                    <button type="button" class="btn btn-default" id="grayscale">Grayscale</button>
                    <button type="button" class="btn btn-default" id="sepia">Sepia</button>
                    <button type="button" class="btn btn-default" id="invert">Invert</button>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <label for="brightness">Brightness</label>
                        <input type="range" class="slider" id="brightness" value="1" step="0.01" min="0.05" max="3">

                        <label for="contrast">Contrast</label>
                        <input type="range" class="slider" id="contrast" value="1" step="0.01" min="0" max="4">

                        <label for="red">R</label>
                        <input type="range" class="slider" id="red" value="1" step="0.01" min="0" max="4">

                        <label for="green">G</label>
                        <input type="range" class="slider" id="green" value="1" step="0.01" min="0" max="4">

                        <label for="blue">B</label>
                        <input type="range" class="slider" id="blue" value="1" step="0.01" min="0" max="4">
                        
                        <label for="alpha">A</label>
                        <input type="range" class="slider" id="alpha" value="1" step="0.01" min="0" max="1">
                    </div>

                </div>
                <div class="btn-group" role="group" aria-label="...">
                    <button type="reset" class="btn btn-primary" id="reset">Reset</button>
                    <button type="button" class="btn btn-primary" id="addtext">Add Text</button>
                </div>
                
            </form>           
        </div>
        
        <div class="col-sm-8">
            <canvas id='postcard' width="720" height="360"></canvas>
        </div>  
        
    </div>
</div>

<script src="imgEditor.js"></script>
<!-- end body -->
<?php require('../inc/footer.php');?>
