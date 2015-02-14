/*

TODO:

* file upload
* better reset/submit
* text color
* possibly canvas, for text overlay image
* best postcard image size
* save/print

*/


var filterValues = {
    'brightness' : 100,
    'contrast' : 100,
    'saturate' : 100,
    'hue-rotate' : 0,
    'grayscale' : 0,
    'sepia' : 0,
    'invert': 0
};


/* from code sample */
function uploadImage(input){

    if(input.files && input.files[0]){
    
        var reader = new FileReader();
        reader.onload = function(e){
            $('#output').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}


function filterString(){
    
    var value, unit;
    var result = "";
    
    for(var filter in filterValues){
        
        value = filterValues[filter];
        unit = (filter != 'hue-rotate') ? '%' : 'deg';
        
        result += filter+'('+value+unit+')';
        
        //don't add space after the last filter
        if(filter != 'invert'){result += ' ';}
    }
    
    return result;
}


function output(){
    var fs = filterString();
    $("#output").css({"-webkit-filter": fs});
}


function setFilter(name, value){   
    filterValues[name] = value;
    output();
}


function reset(){    
    for(var f in filterValues){
        if(f == 'brightness' || f == 'contrast' || f == 'saturate'){
            filterValues[f] = 100;
        }
        else{
            filterValues[f] = 0;
        }
    }   
    output();
    $('output').html('');
}


function sanitize(){
    

}

$('#Reset').click(function(){
    reset();   
});


$('#ChoosePicture').change(function(){
    uploadImage(this);
});


$('#submit').click(function(e){
    e.preventDefault();
    var headline = $('#Headline').val(),
        text = $('#TextArea').val();
    $('output h3').text(headline);
    $('output p').text(text);
});


$('.slider').change(function(){
    var name = $(this).attr('id'),
    value = $(this).val();
    setFilter(name, value);
    
}).mousemove(function(){
    var name = $(this).attr('id'),
    value = $(this).val();
    setFilter(name, value); 
});