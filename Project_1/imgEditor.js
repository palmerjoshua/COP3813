var imagesource = '../img/main_background.jpg',
    canvas = document.getElementById('postcard'),
    context = canvas.getContext('2d');

var original,  // unaltered image
    before,   // image state before each new filter is applied
    current; // image state immediately after each new filter is applied

var imageData = function(){return context.getImageData(0, 0, canvas.width, canvas.height);}

var lastfiltername; // name of last filter applied


function uploadImage(input){

    if(input.files && input.files[0]){
    
        var reader = new FileReader();
        reader.onload = function(e){
            imagesource = e.target.result;
            newCanvasImage(imagesource);
        }
        reader.readAsDataURL(input.files[0]);
    }
}


function newCanvasImage(source){
    original = before = current = null;
    var image = new Image();
    image.src = source;
    image.onload = function(){
        context.drawImage(image,0,0, image.width, image.height, 0,0, canvas.width, canvas.height);
        original = before = imageData();
    };
    //original = image;
}


function revert(){   
    /*if no before, start from original
      else if new filter being used, before = current
      else before stays the same
    */   
    putData(before);
    //context.drawImage(currentimage, 0, 0, currentimage.width, currentimage.height, 0, 0, canvas.width, canvas.height);
}


function putData(imgdata){
    context.putImageData(imgdata, 0, 0);
}


function addText(heading, body){
    // needs work for text placement
    var headingfont = "50px Georgia",
        bodyfont = "20px Georgia";
    context.font = headingfont;
    context.fillText(heading, 50, 50);
    context.font = bodyfont;
    context.fillText(body, 50, 100);
}


function clamp(value){
// keep value in interval [0,255]    
    return (value <= 255 && value >= 0) ? value : ((value > 255) ? 255 : 0);
}


function contrast(value){

}


$('#addtext').click(function(){
    var headline = $('#Headline').val(),
        body = $('#TextArea').val();
    addText(headline, body);
});


$('#ChoosePicture').change(function(){
    uploadImage(this);
});


$('#reset').click(function(){
    putData(original);
    before = current = original;
    lastfiltername = null;
    
    $('p').text('');
});


function beforestate(){

    return (before == original)?'before = original': (before==current)? 'before = current' : 'before=before';
    
}

$('#brightness').change(function(){ 
    
    
    var currentname = $(this).attr('id');
    
    if(currentname != lastfiltername){
        before = current;
    }
    revert();
    var value = $(this).val(),     
        imgdata = imageData(),
        data = imgdata.data;

    for(var i=0; i<data.length; i += 4){
        data[i] = clamp(data[i]*value);
        data[i+1] = clamp(data[i+1]*value);
        data[i+2] = clamp(data[i+2]*value);
    }
    putData(imgdata);
    lastfiltername = currentname;
    current = imageData();
    //$('#currentfilter').text('current: '+currentname);
    //$('#lastfilter').text('last: '+lastfiltername);
    //$('#beforestate').text(beforestate());

    

});


$('#contrast').change(function(){
           
    var currentname = $(this).attr('id');
    if(currentname != lastfiltername){
        before = current;
    }
    revert();
    var value = $(this).val(),
        imgdata = imageData(),
        data = imgdata.data;
    
    for(var i=0; i<data.length; i += 4){
        var avg = Math.round((data[i]+data[i+1]+data[i+2]) / 3),
            red = (avg >= 128) ? data[i]/value : data[i]*value,
            green = (avg >= 128) ? data[i+1]/value : data[i+1]*value,
            blue = (avg >= 128) ? data[i+2]/value : data[i+2]*value;
              
        data[i] = clamp(red);
        data[i+1] = clamp(green);
        data[i+2] = clamp(blue);
    }
    putData(imgdata);
    lastfiltername = currentname;
    current = imageData();
    //$('#currentfilter').text('current: '+currentname);
    //$('#lastfilter').text('last: '+lastfiltername);
    //$('#beforestate').text(beforestate());
   
});


$('#grayscale').click(function(){
    //revert();
    var imgdata = imageData(),
        data = imgdata.data;
    
    for(var i=0; i<data.length; i += 4){
        var avg = Math.round((data[i]+data[i+1]+data[i+2]) / 3);
        data[i] = data[i+1] = data[i+2] = avg;
    }
    putData(imgdata); 
});


$('#invert').click(function(){
    //revert();
    var imgdata = imageData(),
        data = imgdata.data;   
    for(var i=0; i<data.length; i += 4){
        data[i] = 255 - data[i];
        data[i+1] = 255 - data[i+1];
        data[i+2] = 255 - data[i+2];
    }
    putData(imgdata);
 });


$('#sepia').click(function(){
    //revert();
    var imgdata = imageData(),
        data = imgdata.data;   
    
    for(var i=0; i<data.length; i += 4){
        var red = Math.round((data[i] * .393)+(data[i+1] * .769)+(data[i+2]*.189)),
            green = Math.round((data[i] * .349)+(data[i+1] * .686)+(data[i+2]*.168)),
            blue = Math.round((data[i] * .272)+(data[i+1] * .534)+(data[i+2]*.131));
        
        data[i] = (red <= 255) ? red : 255;
        data[i+1] = (green <= 255) ? green : 255;
        data[i+2] = (blue <= 255) ? blue : 255;
    }
    putData(imgdata);
});


$(document).ready(function(){
    newCanvasImage(imagesource);  
});