// globals hold the values from the html form
var startBase, endBase, 
    startNumber, endNumber;

/* HELPERS */

// reverse a string
function reverseString(str) {
    return str.split("").reverse().join("");
}

// determine whether a character is a letter
function isLetter(item){
    return (item >= 'A' && item <= 'Z') || (item >= 'a' && item <= 'z');
}

// force uppercase letters in hexadecimal numbers
function upperHex() {
    if (startBase == 16) {
        startNumber = startNumber.toUpperCase();
    }
    if (endBase == 16) {
        endNumber = endNumber.toUpperCase();
    }
}

// validate user input
function validInput(){
    if(startNumber < 0 || !startNumber){return false;}
    if(!endNumber){return false;}
    
    var bits = startNumber.split(""),
        length = bits.length;
    
    for(i = 0; i < length; i++){
        if(startBase != 16 && isLetter(bits[i])){
            return false;
        } 
        if(startBase == 2 && bits[i] > 1){
            return false;
        }
        if(startBase == 16 && isLetter(bits[i]) && (bits[i] > 'F' || bits[i] > 'f')){
            return false;
        }
    }
    return true;
}

// create output to be loaded into html
function output(){
    
    var output = "<p>";
    
    if(validInput()){
        output += "Start: "+startNumber+"    End: "+endNumber+"<br>";
        output += toDec() + "<br>";
        output += fromDec() + "<br></p>";
    }
    else{
        output = "INVALID INPUT";
    }
    return output;
}


/* SHOW WORK */

// show the work for converting TO base-10
function toDec() {
    if (startBase == 10 || startBase == endBase) {
        return "";
    }

    var result = "";
    var value, start, bit;
    start = reverseString(startNumber);

    for (i = start.length - 1; i >= 0; i--) {
        value = Math.pow(startBase, i);
        bit = parseInt(start[i], 16);

        result += value + '(' + bit + ') ';

        if (i > 0) {
            result += '+ ';
        } else {
            result += '= ';
        }
    }
    result += (endBase == 10) ? endNumber : parseInt(endNumber, endBase);
    return result;
}

//show work for converting FROM base-10
function fromDec() {
    if (endBase == 10 || startBase == endBase) {
        return "";
    }

    var dividend, divisor, quotient, remainder;
    var end, result;

    dividend = (startBase == 10) ? startNumber : parseInt(startNumber, startBase);
    divisor = endBase;
    end = result = "";
    
    while (end != endNumber) {

        quotient = Math.floor(dividend / divisor);
        remainder = dividend % divisor;

        result += dividend + ' / ' + divisor + ' = ' + quotient + ' R' + remainder + '<br>';
        dividend = quotient;
        if (endBase == 16) {
            remainder = remainder.toString(16).toUpperCase();        
        }

        end = remainder + end;
    }
    return result;
}


/* CONVERSION */

function convert() {   
    //to decimal
    endNumber = parseInt(startNumber, startBase);

    //from decimal
    endNumber = endNumber.toString(endBase);
    upperHex();   
}


/* MAIN TRIGGER */

$("#submit").click(function(e){
    e.preventDefault(); // prevent form reloading immediately
    
    startBase = $("input[name='Starting Base']:checked").val();
    endBase = $("input[name='Ending Base']:checked").val();
    startNumber = $("input[name='Starting Number']").val();

    convert();
   
    $('#output').html(output());
    
});