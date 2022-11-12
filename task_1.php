<?php 


## writing a code to check if the entered number is any of the following number types;
$input_var=readline('Enter a number to identify if it is a number: ');

if(is_numeric($input_var)){
    $is_numeric=True;
    if(is_decimal($input_var)){
        echo 'This is a floating point input number';
    }
    
  
    else if(is_int((int)($input_var))){

        echo 'The input is numeric and a integer';
    }
   
}
else 
echo ('The input is not numeric').PHP_EOL;


function is_decimal( $val )
{
    return is_numeric( $val ) && floor( $val ) != $val;
}






?>