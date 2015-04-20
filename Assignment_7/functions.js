var upload = document.getElementById('upload');
//var image = document.getElementById('image');


function uploadImage(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        var image = $(input).siblings('.previewimg');
        reader.onload = function (e) {
            image.attr('src', e.target.result);
            image.css('display', 'initial');
        }

        reader.readAsDataURL(input.files[0]);
    }
};


$(".upload").change(function(){
    uploadImage(this);
});


$('.replylink').on('click', function(){   
    var currentText = $(this).text();
    currentText = (currentText == 'Reply')? 'Close':'Reply';
    $(this).text(currentText);
});


$('.deletelink').on('click', function(){   
    var currentText = $(this).text();
    currentText = (currentText == 'Delete')? 'Close':'Delete';
    $(this).text(currentText);
});


