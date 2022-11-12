<?php

echo convert(2.999997,1);

function convert($float_num,$precision){
    $num_separated=explode('.',$float_num);
    $decimal=substr_replace($num_separated[1],'.',$precision,0);
    if($num_separated[0]>=0){
        $decimal=floor($decimal);
    }
    else
        $decimal=ceil($decimal);
    echo (implode('.',array($num_separated[0],$decimal.PHP_EOL)));
}
?>