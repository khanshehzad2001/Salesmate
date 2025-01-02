<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CSCartAPI;
use App\Models\Product;

class SyncCSCartProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SyncCSCartProducts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Products from CS Cart to the catalog';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(CSCartAPI $client)
    {
        
 
        // $products = Product::search('Samsung Galaxy S22')->paginate();
        // dd($products);
        // $token=base64_encode("powerapp@ecityuae.ae:006blTGg37lvq9Bt4211I25Xu14279dW");
        // dd($token);
        $response = $client->getProducts('/stores/131/products');
        //dd($response->params->total_items);
        $total_pages = (int) ceil($response->params->total_items/10);
        for( $page=0; $page <= $total_pages; $page++ ){
            $response = $client->getProducts('/stores/131/products/?page=' . $page);
            echo($page . " " );
            // var_dump($page);
            foreach($response->products as $product){
               // $product_url= config('services.cscart.home_url') . $product->seo_name;
                //dd($product->product_code);
                // dd($product->main_pair->detailed->image_path);
                $image_url=""; 
                if (isset($product->main_pair) && isset($product->main_pair->detailed) && isset($product->main_pair->detailed->image_path)){ 
                    $image_url=$product->main_pair->detailed->image_path; 
                }

                $product_id = $product->product_id;
                Product::updateOrCreate(
                    ['id' => $product_id],
                    [   
                        'id' => $product_id,
                        'title'=>$product->product,
                        'category_id' => $product->main_category,
                        'product_code'=> $product->product_code,
                        'sap_code' => $product->sap_code,
                        'price' =>  $product->price,
                        'stock'=> $product->amount,
                        'status'=>$product->status,
                        'url'=> config('services.cscart.home_url') . $product->seo_name,
                        'image_url'=> $image_url,
                        'product_data'=> json_encode($product), 
                    ]
                );
                //dd($product->product_id);
             }
        }
    }
}
