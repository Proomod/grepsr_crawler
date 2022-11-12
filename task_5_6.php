<?php


## task 5 and 6 
# Write a crawler to extract data from URL: https://books.toscrape.com/
# Write a code to create a ‘JSON’ file named ‘toscrape_listing.json’ using or reading the
 ## data in the file ‘toscrape_listing.csv’ from Q.5 above.



require 'vendor/autoload.php';
require 'methods.php';
use Symfony\Component\HttpClient\HttpClient;
define("BASEURL", "https://books.toscrape.com/");
define("STRING_TO_FLOAT",array(
    'One'=>'1.0',
    'Two'=>'2.0',
    'Three'=>'3.0',
    'Four'=>'4.0',
    'Five'=>'5.0',
));
$data_array=array();

$client=HttpClient::create()->withOptions([
    'base_uri'=>BASEURL
]);



try {
    $response=$client->request('GET','/');
    //url to scrape
    //convert to domDocument
    $xpath=convert_to_dom_xpath($response);
    $urls_to_scrape_xpath= $xpath->query("//div[@class='side_categories']//a[contains(text(),'Travel')or contains(text(),'Historical Fiction')]/@href");
    foreach($urls_to_scrape_xpath as $url_xpath){
        try {
            $res=$client->request('GET',"/$url_xpath->nodeValue");
            get_required_fields(convert_to_dom_xpath($res),$url_xpath->nodeValue); 
            
 
        } catch (\Throwable $th) {
            throw $th;
        }

    }
} catch (\Throwable $th) {
    echo $th->getMessage();
}
 save_to_json('toscrape_lising.json',json_encode(array('data'=>($data_array),JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT)));
 save_to_csv('toscrape_listing.csv',$data_array);
 $sorted_data_array=array_replace([],$data_array);
 // also since reviews is zero in all the data I assumed you meant to sort by rating instead of reviews.
 usort($sorted_data_array,function($b, $c){return $c['rating']<=> $b['rating'];});
 save_to_csv('reviews_desc.csv',$sorted_data_array);










?>