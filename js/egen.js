/* 
    I really hope putting my email address in a dialog like this
    will prevent spam bots from getting it...
*/

function myad() {
    var a = 'pa'+'lmerjos'+'hua201',
        b = '3@fau',
        c = '.edu';   
    return a+b+c;
} // weak obfuscation...we'll see what happens

$('#dialogOpener').click(function(){
    $('#dialog').dialog('open');
}); // click handler for dialog box

$(document).ready(function(){
    
    // insert address into main html
    $('#dialog').html('<p>'+myad()+'</p>');
    
    // create a dialog box to hold address
    $('#dialog').dialog({
        modal: true,
        autoOpen: false,
        resizable: false,
        buttons: {
            'OK': function(){
                $(this).dialog('close');
            }       
        },
        dialogClass: 'mailbox'
    });    
});