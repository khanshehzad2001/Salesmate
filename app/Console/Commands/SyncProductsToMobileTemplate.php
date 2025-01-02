<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\RainusAPI;
use App\Models\MobileTemplate;
use App\Models\Product;
use GuzzleHttp\Client;
//use Illuminate\Http\Request;



class SyncProductsToMobileTemplate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SyncProductsToMobileTemplate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Products to Mobile Template';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(RainusAPI $client)
    {
      $products = Product::where('category_id', 29)->paginate(20);
      foreach($products as $product) {   
        $product_data = ($product->product_data) ? json_decode($product->product_data) : false; 
        $features = $product->keyFeaturesValues;
        $brand = "";
        $gtin = "";
        $item_model_number="";
        $color="";
        $ram="";
        $storage="";
        $key_features = [];

        foreach($features as $key=>$feature) {
          if($feature['item_key']=="Brand"){
            $brand = $feature['item_value']; 
          } 
          elseif($feature['item_key']=="GTIN") {
            $gtin = $feature['item_value']; 
          } 
          elseif($feature['item_key']=="Item model number") {
            $item_model_number = $feature['item_value']; 
          } 
          elseif($feature['item_key']=="RAM") {
            $ram = $feature['item_value'];
          }
          elseif($feature['item_key']=="GTIN") {
            $gtin = $feature['item_value']; 
          } 
          else {
            //$key_features[] = $feature['item_key'] . ": " . $feature['item_value'];
            $key_features[] = $feature['item_value'];
          }
          
          MobileTemplate::Create(
            [   
                'Title'=>$product->product,
                'Handle'=> config('services.cscart.home_url') . $product->seo_name,
                'Variant SKU'=> $product->product_code,
                'price' =>  $product->price,
            ]
          );
        }
      }
    }
  }