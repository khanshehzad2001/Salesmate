@extends('layouts.app', ['pageSlug' => 'dashboard'])

@section('content')

    <div class="row">
        <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Today Customer Journey</h5>
                    <h3 class="card-title"><i class="tim-icons icon-notes text-primary"></i> {{ $todayCustomerJourneys }} </h3>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">MTD Customer Journey</h5>
                    <h3 class="card-title"><i class="tim-icons icon-calendar-60 text-info"></i>{{$mtdCustomerJourneys}}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">YTD Customer Journey</h5>
                    <h3 class="card-title"><i class="tim-icons icon-calendar-60 text-success"></i> {{$ytdCustomerJourneys}}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Last 10 Customer Journeys</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table tablesorter text-center table-hover" id="customerjourneys-table">
                            <thead class="text-primary thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Phone Number</th>
                                    <th>email</th>
                                    <th>outcome</th>
                                    <th>Products</th>
                                    <th>Reason for Missed Opportunity</th>
                                    <th>remark</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lastTenCustomerJourneys as $journey)
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
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
        @if(session('success'))
                <div class="alert alert-success">
                        <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
                            <i class="tim-icons icon-simple-remove"></i>
                        </button>
                        <span> {{ session('success') }}</span>
                        </div>
                @endif
            <div class="card card-tasks">
                <div class="card-header ">
                    <h6 class="title d-inline">Tasks to be completed</h6>
                </div>
                <div class="card-body">
                    <div class="table-full-width table-responsive">
                        <table class="table tablesorter table-hover">
                            <tbody>
                                @foreach($tasks->sortBy('completed') as $task)
                                <tr>
                                    <td>
                                    <div class="form-check">
                                        <form id="{{ $task->id }}" action="{{ route('tasks.update', $task->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <label class="form-check-label">
                                            <input type="hidden" name="completed" value="0">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       name="completed" 
                                                       value="1" 
                                                       {{ $task->completed ? 'checked' : '' }}
                                                       onchange="submitForm({{ $task->id }})">
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </form>
                                    </div>
                                    </td>
                                    <td>
                                        <p class="title">{{ $task->title }}</p>
                                        <p class="text-muted">{{ $task->content }}</p>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        function submitForm(id) {
            document.getElementById(id).submit();
        }
    </script>
@endpush