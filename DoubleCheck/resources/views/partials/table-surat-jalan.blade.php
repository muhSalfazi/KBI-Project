<section>
    <div class="container">
        <div class="row justify-content-center">
        <div class="col-12 col-lg-12">
            <div class="card widget-card border-light shadow-sm">
            <div class="card-body p-4">
                <h6 class="mb-4">Data Manifest</h6>
                <div class="table-responsive">
                    <table class="table table-borderless bsb-table-xl text-nowrap align-middle m-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Manifest</th>
                                <th>Posting</th>
                                <th>Check  Leader</th>
                                @if(request('loading') == 'true')
                                <th>Prepare</th>
                                <th>Check Surat Jalan</th>
                                <th>Loading Parts</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @if(!isset($datas) || $datas === null || count($datas) === 0)
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data</td>
                            </tr>
                            @else @foreach ($datas as $data )
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $data['dn_no'] }}</td>

                                <td>
                                    @if ($data['scan_admin'] === null)
                                    <span class="badge rounded-pill bg-danger">Open</span>
                                    @elseif ($data['scan_admin'] === 'OK')
                                    <span class="badge rounded-pill bg-success">Close</span>
                                    @else
                                    <b>{{$data['scan_admin']}}</b>
                                    @endif
                                </td>

                                <td>
                                    @if($data['check_leader']  === null)
                                    <span class="badge rounded-pill bg-danger">Open</span>
                                    @elseif($data['check_leader'] == 1)
                                    <span class="badge rounded-pill bg-success">Close</span>
                                    @endif
                                </td>
                                @if(request()->loading == 'true')
                                <td>
                                    @if ($data['prep_member'] === 'Close')
                                    <span class="badge rounded-pill bg-success">{{ $data['prep_member']  }}</span>
                                    @elseif ($data['prep_member']  === 'Open')
                                    <span class="badge rounded-pill bg-danger">{{ $data['prep_member'] }}</span>
                                    @endif
                                </td>

                                <td>
                                    @if($data['check_sj'] === null)
                                    <span class="badge rounded-pill bg-danger">Open</span>
                                    @elseif ($data['check_sj'] === 1)
                                    <span class="badge rounded-pill bg-success">Close</span>
                                    @endif
                                </td>

                                <td>
                                    @if ($data['check_loading'] === null)
                                    <span class="badge rounded-pill bg-danger">Open</span>
                                    @elseif ($data['check_loading'] === 1)
                                    <span class="badge rounded-pill bg-success">Close</span>
                                    @else
                                    <b>{{$data['check_loading']}}</b>
                                    @endif
                                </td>
                                @endif
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
