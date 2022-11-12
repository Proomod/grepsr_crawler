<?php


## methods used in crawling the pages
function get_required_fields($res_xpath,$url){
   
    global $data_array;
    global $client;
   
   foreach( $res_xpath->query('//article[@class="product_pod"]') as $item){
        $product_description=array();
        $product_description['category']=trim($res_xpath->query('//div[@class="page-header action"]')[0]->nodeValue);
        $product_description['category_url']=trim($url);
        $product_description['id']=substr(md5(time()), 0, 8);
        $product_description['title']=$res_xpath->evaluate('.//a[@title]/@title',$item)[0]->nodeValue;
        $product_description['price']=(float) filter_var( $res_xpath->evaluate(".//p[@class='price_color']/text()",$item)[0]->nodeValue, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
        // $product_description['stock']=$res_xpath->evaluate(".//p[contains(@class,'instock')]/text()",$item)[0]->nodeValue;
        $product_description['url']=BASEURL.pathinfo($url,PATHINFO_DIRNAME).'/'.$res_xpath->evaluate(".//a[@title]/@href",$item)[0]->nodeValue;
        $extra_fields=get_extra_fields($product_description['url']);
        $product_description= array_merge($product_description,$extra_fields);
        array_push($data_array,$product_description);
    }

    ## check if page contains next button and scrape it aswell if there is more data
    if(count($res_xpath->evaluate("//li[@class='next']"))!=0){
        $current_url=pathinfo($url,PATHINFO_DIRNAME).'/'.$res_xpath->evaluate("//li[@class='next']/a/@href")[0]->nodeValue;
        try {
            $res=$client->request('GET',$current_url);
            get_required_fields(convert_to_dom_xpath($res),$current_url);
        } catch (\Throwable $th) {
            throw $th;
        }
        
    }
    
}


function get_extra_fields($url){
    global $client;


    try {
        $res=$client->request('GET',$url);
        $res_xpath=convert_to_dom_xpath($res);
        $stock_qty=0;
        if(filter_var($res_xpath->evaluate("//p[contains(@class,'instock') and ancestor::div[contains(@class,'product_main')]]/text()")[1]->nodeValue, FILTER_SANITIZE_NUMBER_INT) ){
            $stock_qty=(int) filter_var($res_xpath->evaluate("//p[contains(@class,'instock') and ancestor::div[contains(@class,'product_main')]]/text()")[1]->nodeValue, FILTER_SANITIZE_NUMBER_INT);
        }
        return array(
            "stock_qty"=> $stock_qty,
             "stock"=>  $stock_qty >0 ? 'In stock' : 'Not In Stock',
            "upc"=>$res_xpath->evaluate("//th[contains(text(),'UPC')]/following-sibling::td/text()")[0]->nodeValue,
            "rating"=>(float)filter_var(STRING_TO_FLOAT[explode(' ',$res_xpath->evaluate("//p[contains(@class,'star-rating') and ancestor::div[contains(@class,'product_main')]]/@class")[0]->nodeValue)[1]],FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
            "reviews"=>intval($res_xpath->evaluate("//th[contains(text(),'Number of reviews')]/following-sibling::td/text()")[0]->nodeValue),

            

        );
    } catch (\Throwable $th) {
        throw $th;
    }

}



function convert_to_dom_xpath($res){
    $doc=new DOMDocument();
    libxml_use_internal_errors(true);
    $doc->loadHTML($res->getContent());
    return new DOMXpath($doc);

}

function save_to_csv($filename,$data_array){
    $f=fopen($filename,'w');
    fputcsv($f,array_keys($data_array[0]));
    foreach($data_array as $data_row){
        fputcsv($f,$data_row);
    }
    fclose($f);
}

function save_to_json($filename,$json){
   try {
    file_put_contents($filename,$json);

   } catch (\Throwable $th) {
    //throw $th;
   }

}






?>