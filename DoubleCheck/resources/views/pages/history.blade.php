@extends('layouts.app', ['title' => 'Riwayat Scan'])

@section('content')
<!-- Table 2 - Bootstrap Brain Component -->
<section class="py-3 py-md-5">
  <div class="container">
    <div class="row justify-content-center">
      <div>
        <div class="card widget-card border-light shadow-sm">
          <div class="card-body p-4">
                <div class="row align-items-center mb-4">
                <!-- Judul -->
                <div class="col">
                    <h5 class="card-title widget-card-title mb-0">{{ $judul }}</h5>
                </div>

                <!-- Filter Form -->
                <div class="col-auto">
                    <form method="GET" action="{{ route(\Illuminate\Support\Facades\Route::currentRouteName()) }}" class="d-flex gap-2">
                    <input type="text" id="dateRange" name="date_range" class="form-control"
                            placeholder="Pilih periode tanggal"
                            value="{{ request('date_range') }}">

                    <button type="submit" class="btn btn-primary">Filter</button>
                    </form>
                </div>

                <div class="col-auto">
                    <a href="{{ url()->current() }}?date_range={{ request('date_range') }}&export=true" class="btn btn-success">
                        Export Excel
                    </a>
                </div>
                </div>
            <div class="table-responsive">
              <table class="table table-borderless bsb-table-xl text-nowrap align-middle m-0">
                <thead>
                  <tr>
                    <th>No.DN/Manifest</th>

                    @if(request()->segment(2) == 'leader' || request()->segment(2) == 'loading')
                    <th>Part Name</th>
                    <th>Part Number</th>
                    <th>Sequence</th>
                    @endif
                    <th>Waktu</th>
                    <th>User</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($data as $d)
                    <tr>

                    @if(request()->segment(2) == 'leader' || request()->segment(2) == 'loading')
                        <td>{{$d->dn_no}}</td>
                        <td>{{ $d->part_name}} </td>
                        <td>{{ $d->part_number}} </td>
                        <td>{{ $d->seq_no}} </td>
                        <td>{{ $d->checked_at}} </td>

                        @if(request()->segment(2) == 'loading')
                        <td>{{ $d->loading->full_name ?? '-' }} </td>
                        @else
                        <td>{{ $d->checker->full_name}} </td>
                        @endif

                    @else
                        <td>{{$d->no_dn}}</td>
                        <td>{{$d->created_at}}</td>
                        <td>{{$d->scanByUser->full_name}}</td>
                    @endif

                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            {{ $data->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
</div>
</div>
</section>
<script>
  $(function() {
  $('input[name="date_range"]').daterangepicker({
        opens: 'left'
    }, function(start, end, label) {
        console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });
    });
</script>
@endsection
