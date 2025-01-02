@extends('layouts.app', ['pageSlug' => 'productdiscovery'])

@section('content')
<div class="card">
    <h2 class="text-center p-1">AI Driven Product Discovery</h2>
    <div class="row container-fluid">
        @foreach($productDiscoveries as  $productDiscovery)
        <div class="col-md-4 col-sm-6">
        <div class="card bottom curve p-1 text-center" style="background-color:aliceblue; min-height:250px; max-height:300px">
        <a href="{{ route('productdiscovery.show', $productDiscovery->id) }}" style="text-decoration:underline; color:black">
            <img src="{{ $productDiscovery->image_url }}" style="max-height:200px">
            <div class="card-body">    
            {{ $productDiscovery->title }}
            </div>
        </a>
        </div>
        
        </div>
        @endforeach
    </div>
</div>
@endsection