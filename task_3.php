<?php

$input_date_format_one="Sep 20 2021"; # please provide text in similar format if you want to change the value
$input_date_format_two="09092021";

$date1=DateTimeImmutable::createFromFormat('M d Y',$input_date_format_one);
$date2=DateTimeImmutable::createFromFormat('dmY',$input_date_format_two);



echo(($date1->format('Y-m-d'))).PHP_EOL;
echo(($date2->format('M-d-Y'))).PHP_EOL;



?>
