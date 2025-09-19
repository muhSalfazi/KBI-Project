<section>
    <div class="container">
        <div class="row justify-content-center">
        <div class="col-12 col-lg-12">
            <div class="card widget-card border-light shadow-sm">
            <div class="card-body p-4">
                <h6 class="mb-4">Data Parts</h6>
                    <div class="table-responsive">
                    <table class="table table-borderless bsb-table-xl text-nowrap align-middle m-0">
                        <thead>
                            <tr>
                                <th>Inv ID</th>
                                <th>Part Name</th>
                                <th>Part Number</th>
                                <!-- <th>Qty Order</th> -->
                                @if(request('loading') == 'true')
                                <th>Scan Loading</th>
                                @else
                                <th>Qty Actual</th>
                                <th>Prepare</th>
                                <th>Check Leader</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if(!isset($dataParts) || $dataParts === null
                            || count($dataParts) === 0)
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data</td>
                            </tr>
                            @else @foreach ($dataParts as $part )
                            <tr>
                                <td>{{ $part['inv_id'] }}</td>
                                <td>{{ $part['part_name'] }}</td>
                                <td>{{ $part['part_no'] }}</td>
                                <!-- <td>{{ $part['qty_pcs'] }}</td> -->

                                @if(request('loading') == 'true')
                                <td>
                                    @if($part['qty_loading_check'] === $part['total_label'])
                                    <span class="badge rounded-pill bg-success">Close</span>
                                    @else
                                    <b>{{ $part['qty_loading_check'] }}/{{$part['total_label'] }}</b>
                                    @endif
                                </td>
                                @else
                                <td>{{ $part['QtyPerKbn'] * $part['total_checked'] }}</td>
                                <td>
                                    @if ($part['status_label'] === 'Close')
                                    <span class="badge rounded-pill bg-success">{{ $part['status_label'] }}</span>
                                    @elseif ($part['status_label'] === 'Open')
                                    <span class="badge rounded-pill bg-danger">Open</span>
                                    @endif
                                </td>
                                <td>
                                    @if($part['total_checked'] === 0)
                                    <span class="badge rounded-pill bg-danger">Open</span>
                                    @elseif($part['total_checked'] === $part['total_label'])
                                    <span class="badge rounded-pill bg-success">Close</span>
                                    @else
                                    <b>{{ $part['total_checked'] }}/{{ $part['total_label'] }}</b>
                                    @endif
                                </td>
                                @endif
                            </tr>
                            @endforeach @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </div>
</section>
