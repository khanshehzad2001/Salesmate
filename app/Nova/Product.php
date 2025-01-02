<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;

class Product extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Product>
     */
    public static $model = \App\Models\Product::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','title','product_code','sap_code',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('title')
                ->sortable()
                ->rules('required', 'max:255'),
            
            BelongsTo::make('Category','category',Category::class)
                ->sortable()->searchable()
                ->rules('required'),

            Text::make('Product Code', 'product_code')
                ->sortable()
                ->rules('required', 'max:255'),
            
            Text::make('SAP Code', 'sap_code')
                ->sortable()
                ->rules('required', 'max:255'),
            
            Number::make('Price')
                ->sortable()
                ->rules('required', 'numeric'),
            
            Text::make('Stock')
                ->sortable()
                ->rules('required', 'numeric'),
            
            Text::make('Status')
                ->sortable()
                ->rules('nullable', 'max:255'),
            
            Number::make('Popularity')
                ->sortable()->default(0),
    
            Text::make('Product Data', 'product_data')
                ->sortable()
                ->rules('nullable', 'json'),
    
            Text::make('URL', 'url')
                ->sortable()
                ->rules('required', 'url'),
    
            Text::make('Image URL', 'image_url')
                ->sortable()
                ->rules('required', 'url'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
