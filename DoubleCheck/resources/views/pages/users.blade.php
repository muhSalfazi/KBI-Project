@extends('layouts.app', ['title' => 'Riwayat Scan'])

@section('content')
<!-- Table 2 - Bootstrap Brain Component -->
<section class="py-3 py-md-5">
  <div class="container">
    <div class="row justify-content-center">
      <div>
        <div class="card widget-card border-light shadow-sm">
          <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="card-title widget-card-title mb-4">{{ $judul }}</h5>
                <div class="search-bar">
                    <form action="{{ route('user.userManagement') }}" method="get">
                    <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari ID/Nama" aria-label="Search" aria-describedby="search-addon" name="search">
                            <button class="btn btn-outline-secondary" type="submit" id="search-addon">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
              <table class="table table-borderless bsb-table-xl text-nowrap align-middle m-0">
                <thead>
                  <tr>
                    <th>ID Card</th>
                    <th>Nama</th>
                    <th>Role/Job</th>
                    <th>Terakhir Login</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($data as $d)
                    <tr>
                        <td>{{ $d->username }}</td>
                        <td>{{ $d->full_name }}</td>
                        <td>{{ $d->role->departemen }}</td>
                        <td>{{ $d->last_login }}</td>

                        <!-- kalau di publish, == ada 2 -->
                        @if($d->is_blocked == 0)
                        <td> <span class="badge rounded-pill bg-success">Aktif</span> </td>
                        <td> - </td>
                        @else
                        <td> <span class="badge rounded-pill bg-danger">Blok</span> </td>
                        <td>
                            <form action="{{ route('user.unblock', ['id' => $d->id_user]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-link btn-danger" onclick="return confirm('Apakah Anda yakin ingin membuka blokir user ini?')">Unblock</button>
                            </form>
                        </td>
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
@endsection
