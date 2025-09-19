<section>
    <div class="container">
        <div class="row justify-content-center">
        <div class="col-12 col-lg-12">
            <div class="card widget-card border-light shadow-sm">
            <div class="card-body p-4">
                <h5 class="mb-4">Data Manifest</h5>
                <div class="table-responsive">
                <table class="table table-borderless bsb-table-xl text-nowrap align-middle m-0">
                    <thead>
                        <tr>
                            <th>Manifest</th>

                            @if(request()->segment(1) === 'scan-admin')
                                <th>Posting</th>
                                <th>Check Leader</th>
                            @else
                                <th>Posting</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                    @if(!isset($manifests) || $manifests === null || count($manifests) === 0)
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data</td>
                        </tr>
                    @else
                        @foreach ($manifests as $manifest )
                        <tr>
                            <td>{{ $manifest->first()->dn_no }}</td>
                            <td>
                                @if ($manifest->first()->status === null)
                                    <span class="badge rounded-pill bg-danger">Open</span>
                                @elseif ($manifest->first()->status === 'OK')
                                    <span class="badge rounded-pill bg-success">Close</span>
                                @else
                                    <b>Open</b> {{-- Tampilkan status apa adanya jika bukan null, OK, atau NG --}}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            </div>
        </div>
        </div>
    </div>
</section>
