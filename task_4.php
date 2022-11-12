<?php


// this separates string from any of the following separators: _ @ .
$given_string="abc_xyz@grepsr.com";

$string_=preg_split("/[_@.]+/",$given_string);
echo implode(',',$string_).PHP_EOL;



?>  
