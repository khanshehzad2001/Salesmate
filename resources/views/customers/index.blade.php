@extends('layouts.app', ['pageSlug' => 'customers'])

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card ">
      <div class="card-header">
        <h4 class="card-title"> Customer Table</h4>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
            <form action="{{ route('customer.search') }}" method="GET" id="searchForm">
              <input type="text" class="form-control" name="searchCustomer" id="searchInput" placeholder="Search by name or phone number" value="{{ request('searchCustomer') }}" autocomplete="off">
            </form>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table tablesorter text-center table-hover" id="customerTable">
            <thead class="text-primary thead-light">
              <tr>
                <th>
                  ID
                </th>
                <th>
                  Name
                </th>
                <th>
                  Email
                </th>
                <th>
                  Phone Number
                </th>
              </tr>
            </thead>
            <tbody>
            @foreach ($Customers as $customer)
                <tr>
                  <td>
                    {{ $customer->id }}
                  </td>
                  <td>
                    {{ $customer->name }}
                  </td>
                  <td>
                    {{ $customer->email }}
                  </td>
                  <td>
                    {{ $customer->phone_number }}
                  </td>
                </tr>
                @endforeach
            </tbody>
          </table>
          <div id="pagination" class="d-flex justify-content-center">
              {{ $Customers->links('vendor.pagination.bootstrap-5') }}
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