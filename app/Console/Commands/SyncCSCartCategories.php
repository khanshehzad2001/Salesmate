<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CSCartAPI;
use App\Models\Category;

class SyncCSCartCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SyncCSCartCategories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Product categories from CSCart';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(CSCartAPI $client)
    {
        $response = $client->getCategories('/categories');
        $total_pages = (int) ceil($response->params->total_items/10);
        //dd($total_pages);
        for( $page=1; $page <= $total_pages; $page++ ){
            $response = $client->getProducts('/categories?page=' . $page);
           var_dump($page);
            foreach($response->categories as $category){
                $category_id = $category->category_id;
                Category::updateOrCreate(
                    ['id' => $category_id],
                    [ 
                        'id' => $category_id,
                        //'category_data'=> json_encode($category),
                        'name' => $category->category
                    ]
                );
                //dd($category->category_id);
             }
        }
        dd($total_pages);
    }
}
