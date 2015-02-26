var imagesource = '../img/main_background.jpg',
    canvas = document.getElementById('postcard'),
    context = canvas.getContext('2d');

var imageData = function(){return context.getImageData(0, 0, canvas.width, canvas.height);}

var original = null;

var filters = {};

var functions = {
    
    
    'grayscale': function(value){
        
        var imgdata = imageData(),
        data = imgdata.data;
    
        for(var i=0; i<data.length; i += 4){
        var avg = Math.round((data[i]+data[i+1]+data[i+2]) / 3);
        data[i] = data[i+1] = data[i+2] = avg;
        }
        putData(imgdata); 
    },
    
    
    'sepia': function(value){
        
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
    },
    
    
    'invert': function(value){
        
        var imgdata = imageData(),
            data = imgdata.data;   
        for(var i=0; i<data.length; i += 4){
            data[i] = 255 - data[i];
            data[i+1] = 255 - data[i+1];
            data[i+2] = 255 - data[i+2];
        }
        putData(imgdata);
    },
    
    
    'brightness': function(value){
       
        var imgdata = imageData(),
            data = imgdata.data;

        for(var i=0; i<data.length; i += 4){
            data[i] = clamp(data[i]*value);
            data[i+1] = clamp(data[i+1]*value);
            data[i+2] = clamp(data[i+2]*value);
        }
        putData(imgdata);
        
    },
    
    
    'contrast': function(value){
    
        var imgdata = imageData(),
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
    }
};


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
    var image = new Image();
    image.src = source;
    image.onload = function(){
        context.drawImage(image,0,0, image.width, image.height, 0,0, canvas.width, canvas.height);
        original = imageData();
    };
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


function update(name, value){
    switch(name){// button filters don't layer
        case 'grayscale':
            if('sepia' in filters){
                delete filters['sepia'];
            }
            if('invert' in filters){
                delete filters['invert'];
            }
            break;
        case 'sepia':
            if('grayscale' in filters){
                delete filters['grayscale'];
            }
            if('invert' in filters){
                delete filters['invert'];
            }
            break;
        case 'invert':
            if('sepia' in filters){
                delete filters['sepia'];
            }
            if('grayscale' in filters){
                delete filters['grayscale'];
            }
        default:
            break;
    }
    
    
    filters[name] = value;
    putData(original);
    for(var filter in filters){
        functions[filter](filters[filter]);
    }
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
    filters = {};
    $('p').text('');
});


$('#brightness').change(function(){ 
    
    var name = $(this).attr('id'),
        value = $(this).val();

    update(name, value);    
});


$('#contrast').change(function(){
    var name = $(this).attr('id'),
        value = $(this).val();

    update(name, value);   
});


$('#grayscale').click(function(){
    var name = $(this).attr('id');

    update(name, null);   
});


$('#invert').click(function(){
    var name = $(this).attr('id');

    update(name, null);  
 });


$('#sepia').click(function(){
    var name = $(this).attr('id');

    update(name, null);
});


$(document).ready(function(){
    newCanvasImage(imagesource);  
});