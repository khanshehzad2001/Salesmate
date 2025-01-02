@extends('layouts.app', ['pageSlug' => 'productdiscovery'])

@section('content')
<div class="card col-lg-12 col-md-12">
    <h2 class="text-center p-1">AI Driven Product Discovery</h2>
    
    <div id="zoovu-assistant">
        {!! $productDiscovery->script !!}
    </div>
</div>
@endsection