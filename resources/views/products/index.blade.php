@extends('layouts.app', ['pageSlug' => 'products'])

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card ">
      <div class="card-header">
        <h4 class="card-title"> Product Table</h4>
      </div>
      <div class="card-body">
      <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <form action="/product/search">
              <input type="text" class="form-control" name="search" placeholder="Kindly search product by Name" autocomplete="off">
              </form>

            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table tablesorter text-center table-hover" id="productTable">
            <thead class="text-primary thead-light">
              <tr>
                <th>
                  ID
                </th>
                <th>
                  Image
                </th>
                <th>
                  Name
                </th>
                <th>
                  Product Code
                </th>
                <th>
                  SAP Code
                </th>
                <th>
                  Price
                </th>
                <th>
                  Stock
                </th>
                <th>
                  Status
                </th>
                <th>
                  Popularity
                </th>
              </tr>
            </thead>
            <tbody id="ProductBody">
              @foreach ($products as $product)
                <tr data-entry-id="{{ $product->id }}">
                  <td>
                    {{ $product->id }}
                  </td>
                  <td>
                    <a href="{{ $product->url }}" target="_blank">
                      <img src="{{ $product->image_url }}" alt="No Image" style="max-width: 100px;">
                    </a>
                  </td>
                  <td>
                    {{ $product->title }}
                  </td>
                  <td>
                    {{ $product->product_code }}
                  </td>
                  <td>
                    {{ $product->sap_code }}
                  </td>
                  <td>
                    {{ $product->price }}
                  </td>
                  <td>
                    {{ $product->stock }}
                  </td>
                  <td>
                    {{ $product->status }}
                  </td>
                  <td>
                    {{ $product->popularity }}
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <div id="pagination" class="d-flex justify-content-center">
              {{ $products->links('vendor.pagination.bootstrap-5') }}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection