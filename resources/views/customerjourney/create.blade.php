@extends('layouts.app', ['pageSlug' => 'customerjourney'])

@section('content')

@if(session('success'))
<div class="alert alert-success">
          <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
            <i class="tim-icons icon-simple-remove"></i>
          </button>
          <span> {{ session('success') }}</span>
        </div>
@endif

@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
        <i class="tim-icons icon-simple-remove"></i>
    </button>
    <span>
        @foreach ($errors->all() as $error)
            {{ $error }}
        @endforeach
    </span>
</div>
@endif

<div class="card">
    <div class="card-header">
        <h4 class="card-title">Create Customer Journey</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('customerjourney.store') }}" method="post" id="customerJourneyForm" name="customerJourneyForm">
            @csrf
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                                <label for="phone_number">Phone Number</label>
                                <input type="number" name="phone_number" id="phone_number" class="form-control" placeholder="Please enter phone number with country code (e.g.971)" required>
                                @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                                <label for="customer_name">Customer Name</label>
                                <input type="text" name="customer_name" id="customer_name" class="form-control" autocomplete="on" placeholder="Customer Name" required>
                                @error('customer_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                    </div>
                </div>   
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" autocomplete="on" placeholder="Customer Email" required>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="outcome_id">Grouping</label>
                        <select name="outcome_id" id="outcome_id" class="form-control @error('outcome_id') is-invalid @enderror" required>
                            <option value="" selected disabled>Select a group</option>
                            @foreach ($outcomes as $outcome)
                                <option value="{{ $outcome->id }}" {{ old('outcome_id') == $outcome->id ? 'selected' : '' }}>
                                    {{ $outcome->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('outcome_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="products">Products</label>
                <select id="products" name="products[]" class="form-control" multiple="multiple" required></select>
                @error('products')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="reason">Reason for Missed Opportunity</label>
                        <textarea name="reason" id="reason" class="form-control" placeholder="Input reason for missed opportunity, if any"></textarea>
                        @error('reason')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="remark">Remark</label>
                        <textarea name="remark" id="remark" class="form-control" placeholder="Input remark here... if any"></textarea>
                        @error('remark')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" id="submit">Submit</button>
        </form>
    </div>
</div>
@endsection

@push('js')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>    
    <!-- Algolia InstantSearch library -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>

    <script>
    $(document).ready(function() {

        $('#phone_number').on('input', function() {
            var phoneNumber = $(this).val();
            if (phoneNumber.trim().length >= 6) {
                $.ajax({
                    url: '{{ route("customerjourney.searchPhoneNumber") }}',
                    method: 'GET',
                    data: {term: phoneNumber},
                    success: function(response) {
                        if (response.customer_id) {
                            $('#customer_name').val(response.customer_name).prop('readonly', true);
                            $('#email').val(response.email).prop('readonly', true);
                            $('#customer_id').val(response.customer_id);
                        } else {
                            $('#customer_id').val('');
                            $('#customer_name').val('').prop('readonly', false);
                            $('#email').val('').prop('readonly', false);
                        }
                    }
                });
            }
        });

        var algoliaClient = algoliasearch('W8UV29XBRJ', '0308c94582bd8c19ce855266eccb9df6');
        var productsIndex = algoliaClient.initIndex('prod_smproducts');

        $('#products').select2({
            ajax: {
                transport: function (params, success, failure) {
                    productsIndex.search(params.data.term, { hitsPerPage: 10 }).then(function (algoliaResponse) {
                        success({
                            results: algoliaResponse.hits.map(function (hit) {
                                return { id: hit.id, text: hit.title };
                            })
                        });
                    }).catch(failure);
                },
                processResults: function (data) {
                    return data;
                },
                delay: 250,
                minimumInputLength: 2,
            },
            placeholder: 'Search for products',
            multiple: true,
            width: '100%',
            tabindex: 0,
        });


        $('#outcome_id').select2({
            placeholder: 'Select a group',
            allowClear: true,
            minimumResultsForSearch: 100,
            width:'100%',
            tabindex: 0,
        });
    });
    </script>
    <style>
    .select2-results__option:hover {
        background-color: #f0f0f0; 
        cursor:pointer;
    }
    </style>
@endpush