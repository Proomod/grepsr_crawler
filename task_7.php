<?php 
require 'vendor/autoload.php';
require 'methods.php';

use Symfony\Component\HttpClient\HttpClient;

$client=HttpClient::create();

//I was confused if you wanted a categories only or product csv so I made both 
// file name 'categories.csv and categories_alternate.csv

try {
    $res=$client->request('GET','https://dummyjson.com/products');
    $res_2=$client->request('GET','https://dummyjson.com/products/categories');
    if($res->getStatusCode()==200 && $res->getStatusCode()==200){
        $data_array_orginal=$res->toArray()['products'];
        $data_array_required=array();
        foreach($data_array_orginal as $data){
            array_push($data_array_required,Array('category'=>$data['category'],'title'=>$data['title'
            ]));
        }
        save_to_csv('categories.csv',array_map( fn(string $category):Array => Array('category'=>$category) ,$res_2->toArray()));

        save_to_csv('categories_alternate.csv',$data_array_required);

    }


} catch (\Throwable $th) {
    throw $th;
}


?>