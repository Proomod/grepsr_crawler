<?php

##This is task 8 
## Create a crawler to Login & Print (an array), with available unique ‘Tags’ (from Page 1).

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;
require 'vendor/autoload.php';
require 'methods.php';


define ('BASEURL','https://toscrape.com/index.html');





$client=HttpClient::create();

// first go to index.html

try {
    $res=$client->request('GET',BASEURL);
    $login_url=convert_to_dom_xpath($res)->evaluate("//a[.='Login']/@href")[0]->nodeValue;
    $formdata=new FormDataPart([
        'username'=>'pramod', 

    ]);
    $login_res=$client->request('POST',$login_url,[
        'headers'=>$formdata->getPreparedHeaders()->toArray(),
        'body'=>$formdata->bodyToString()
    ]

    );
    if($login_res->getStatusCode() == 200 || 201){
        // scrape the logged in page
        scrape_quotes(convert_to_dom_xpath($login_res));

    }

    // login first and then get to main site


} catch (\Throwable $th) {
    throw $th;
}


function scrape_quotes($res_xpath){
$all_unique_tags_from_page=array();
  foreach($res_xpath->query("//div[@class='tags']/a/text()") as $tags){
    array_push($all_unique_tags_from_page,$tags->nodeValue);
  }
  echo "The list of unique tags in page one are :".'['.implode(',',array_unique($all_unique_tags_from_page)).']'.PHP_EOL;

    

}







?>