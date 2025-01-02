@extends('layouts.app', ['pageSlug' => 'customerjourneys'])

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Customer Journeys</h4>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <form action="{{ route('customerjourney.searchJourneys') }}" method="GET" id="searchForm">
                <input type="text" class="form-control" name="searchJourneys" id="searchInput" placeholder="Search by customer name or phone number" value="{{ request('searchJourneys') }}" autocomplete="off">
              </form>
            </div>
          </div>
          <div class="col-md-6 text-right">
            <form action="{{ route('customerjourney.create') }}">
              <button class="btn btn-primary" style="margin-bottom:20px">Create New Journey</button>
            </form>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table tablesorter text-center table-hover" id="customerjourneys-table" >
            <thead class="text-primary thead-light">
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Email</th>
                <th>Outcome</th>
                <th>Products</th>
                <th>Reason for Missed Opportunity</th>
                <th>Remark</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($CustomerJourneys as $journey)
              <tr>
                <td>{{ $journey->id }}</td>
                <td>{{ $journey->customer_name }}</td>
                <td>{{ $journey->phone_number }}</td>
                <td>{{ $journey->email }}</td>
                <td>{{ $journey->outcome->title }}</td>
                <td> @foreach ($journey->products as $product)
                      <li>{{ $product->title }} </li> <br>
                    @endforeach
                </td>
                <td>{{ $journey->reason }}</td>
                <td>{{ $journey->remark }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <div id="pagination" class="d-flex justify-content-center">
              {{ $CustomerJourneys->links('vendor.pagination.bootstrap-5') }}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@push('js')
<script>
document.addEventListener("DOMContentLoaded", function() {
  const searchInput = document.getElementById('searchInput');
  const searchForm = document.getElementById('searchForm');

  searchInput.addEventListener('input', function() {
    if (this.value.trim() === '') {
      searchForm.submit();
    }
  });
});
</script>
@endpush