var imagesource = '../img/main_background.jpg',
    canvas = document.getElementById('postcard'),
    context = canvas.getContext('2d'),
    imageData = function(){
        return context.getImageData(0, 0, canvas.width, canvas.height);
    };

var original = headline = body = null,
    textwritten = false,
    filters = {}; 


/* FILTER FUNCTIONS */
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
    },
    
    
    onecolor: function(offset, value){
        var imgdata = imageData(),
            data = imgdata.data;
        
        for(var i=0; i<data.length; i += 4){
            var color = data[i+offset]*value;
            data[i+offset] = clamp(color);
        }
        putData(imgdata);
    },
    
    
    'red': function(value){
        this.onecolor(0, value);    
    },
    
    
    'green': function(value){
        this.onecolor(1, value);
    },
    
    
    'blue': function(value){
        this.onecolor(2, value);       
    },
    
    'alpha': function(value){
        this.onecolor(3, value);
    }
};


/* HELPER FUNCTIONS */
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


function apply(){
    putData(original);
    for(var filter in filters){
        functions[filter](filters[filter]);
    }
}


function update(name, value){
    switch(name){
    // button filters don't layer
        case 'grayscale':
            delete filters['sepia'];
            delete filters['invert'];       
            break;
        case 'sepia':
            delete filters['grayscale'];
            delete filters['invert'];
            break;
        case 'invert':
            delete filters['sepia'];
            delete filters['grayscale'];
        default:
            break;
    }
    
    
    filters[name] = value;
    apply();
}


function addText(){
    // needs work for text placement
    var headlinefont = "50px Georgia",
        bodyfont = "20px Georgia";
    
    putData(original);
    apply();
                
    context.font = headlinefont;
    context.fillText(headline, 50, 50);  
    
    context.font = bodyfont;
    
    var x = 50; 
    var y = 100;
    
    var maxwidth = canvas.width - 100;
    var measure = context.measureText("M");
    var lineheight = Math.ceil(measure.width);
    var words = body.split(' ');
    var line = '';
    
    for(var n=0; n<words.length; n++){
        var testline = words[n] + ' ';
       
        if(context.measureText(line+testline).width < maxwidth){
            line += testline;
        }else{
            context.fillText(line, x, y);
            line = testline;
            y += lineheight;        
        }
    }
    if(line.length > 0){
        context.fillText(line, x, y);
    }
    textwritten = true;
}


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


function download(){
    this.download = Math.random().toString(36).slice(2,8);
    this.href = canvas.toDataURL('image/png');
}


function clamp(value){
// keep value in interval [0,255]    
    return (value <= 255 && value >= 0) ? value : ((value > 255) ? 255 : 0);
}



/* EVENT HANDLERS */

document.getElementById('downloadlink').addEventListener('click', download, false);

$('#addtext').click(function(){
    headline = $('#Headline').val();
    body = $('#TextArea').val();
    addText();
});


$('#ChoosePicture').change(function(){
    uploadImage(this);
});


$('#reset').click(function(){
    putData(original);
    filters = {};
    textwritten = false;
    headline = body = false;
});


$('.btn-default').click(function(){
    var name = $(this).attr('id');
    update(name, null);
    if(textwritten){
        addText();
    }
});


$('.slider').change(function(){
    var name = $(this).attr('id'),
        value = $(this).val();
    update(name, value);
    if(textwritten){
        addText();
    }
})/*.mousemove(function(){
    var name = $(this).attr('id'),
        value = $(this).val();
    update(name, value);
    if(textwritten){
        addText();
    }
})*/;


$(document).ready(function(){
    newCanvasImage(imagesource);  
});