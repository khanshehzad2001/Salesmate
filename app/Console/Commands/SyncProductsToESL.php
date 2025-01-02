<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\RainusAPI;
use App\Models\Product;
use App\Models\Store;
use GuzzleHttp\Client;
//use Illuminate\Http\Request;



class SyncProductsToESL extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SyncProductsToESL';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Products to ESL';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(RainusAPI $client)
    {
        $stores = Store::where('esl_enabled',true)->get();
        $products_object = [];
        foreach($stores as $store) {
            $products = Product::with('category')->paginate(20);
            foreach($products as $product) {
                $product_data = ($product->product_data) ? json_decode($product->product_data) : false; 
                $features = $product->keyFeaturesValues;
                $brand = "";
                $gtin = "";
                $pr_info = [];
                $key_features = [];
               
                foreach($features as $key=>$feature) {
                  if($feature['item_key']=="Brand"){
                    $brand = $feature['item_value']; 
                  } elseif($feature['item_key']=="GTIN") {
                    $gtin = $feature['item_value']; 
                  } else {
                    //$key_features[] = $feature['item_key'] . ": " . $feature['item_value'];
                    $key_features[] = $feature['item_value'];
                  }
                }

                $pr_info[] = $brand;
                $pr_info[] = $gtin;
                $pr_info[] = $product->category->name;
                $pr_info[] = $product_data->product;
                $pr_info[] = $product->product_code;
                $pr_info[] = $product_data->price; // Price with added discount
                $pr_info[] = ""; // Discount
                $pr_info[] = "";
                $pr_info[] = "";
                $pr_info = array_merge($pr_info, $key_features);  

                $esl_product = (object) [
                                    "prCode" => $product->product_code,
                                    "layoutId" => "LAYOUTID_2",
                                    "nfc" => $product->product_url,
                                    "prInfo"=> $pr_info                          
                                ];
                $products_object[] = $esl_product;                  
            }
            $body = (object) [];
            $body->taskId = -1;
            $body->priorTaskId = -1;
            $body->storeCode = (string) $store->id;
            $body->product = $products_object;
            $body = json_encode($body);
            $response = $client->postProducts('api/product', $body);
            var_dump($response);

        }
    }
}
