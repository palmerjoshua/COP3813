$(document).ready(function(){
    $('nav').removeClass('navbar-inverse');
    $('nav').addClass('navbar-default');
    inputOpen = false;
    listItemCounter = 0;
    listInput = '<input type="text" id="listInput" class="form-control" maxlength="30" placeholder="Enter List Item">';
    itemChecked = {};
});

var currentItemID = function(){
    return '#item'+listItemCounter.toString();
}

var $currentItem = function(){ 
    return $(currentItemID());
}

var itemLink = function(){
    return '<div class="list-group-item" id="item'+ (++listItemCounter) +'"></div>';
}

$('#mainButton').on('click', function(){    
    $(this).children().toggleClass('glyphicon-pencil');
    inputOpen = !inputOpen;
    if(inputOpen){       
        $(listInput).insertBefore(this);
        $('#listInput').focus();
    }else{
        var itemText = $('#listInput').val();
        if(itemText.length > 0){
            $('.list-group').append(itemLink());
            addItemEvents($currentItem());                      
            $currentItem().text(itemText);
            $currentItem().append('<span></span>');
            itemChecked[currentItemID().slice(1)] = false;
        }        
        $('#listInput').remove();
    }
});

function addItemEvents($listItem){ 
    $listItem.hover(
        function(){
            var id = $(this).attr('id'),
                $span = $(this).children('span');
            
            if(itemChecked[id]){
                $span.removeClass('glyphicon glyphicon-ok');
                $span.addClass('glyphicon glyphicon-trash');
            }else{
                $span.addClass('glyphicon glyphicon-ok');
            }         

        },
        function(){
            var id = $(this).attr('id'),
                $span = $(this).children('span');
            if(itemChecked[id]){
                $span.removeClass('glyphicon glyphicon-trash');
                $span.addClass('glyphicon glyphicon-ok');
            }else{
                $span.removeClass('glyphicon glyphicon-ok');
            }
        }
    );     
    $listItem.on('click', function(){
        var id = $(this).attr('id');
        if(!itemChecked[id]){
            itemChecked[id] = true;
        }else{
            $(this).remove();
        }
    });
}