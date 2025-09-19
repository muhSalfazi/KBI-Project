<section>
    <div class="container">
        <div class="row justify-content-center">
        <div class="col-12 col-lg-12">
            <div class="card widget-card border-light shadow-sm">
            <div class="card-body p-4">
                <h6 class="mb-4">Data Parts</h6>
                    <div class="table-responsive">
                    <table class="table table-borderless bsb-table-xl text-nowrap align-middle m-0" id="tableParts">
                        <thead>
                            <tr>
                                <th>Inv ID</th>
                                <th>Part Name</th>
                                <th>Part Number</th>
                                <th>Qty Order</th>
                                <th>Qty Loading</th>
                                <th>Scan Loading</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!isset($dataParts) || $dataParts === null
                            || count($dataParts) === 0)
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data</td>
                            </tr>
                            @else @foreach ($dataParts as $part )
                            <tr>
                                <td>{{ $part->InvId }}</td>
                                <td>{{ $part->part_name }}</td>
                                <td>{{ $part->part_no }}</td>
                                <td>{{ $part->qty_pcs }}</td>
                                <td>{{ $part->QtyPerKbn * ($part->qty_loading_check ?? 0) }}</td>

                                <td>
                                    @if($part->qty_loading_check == $part->total_label)
                                    <span class="badge rounded-pill bg-success">Close</span>
                                    @elseif($part->qty_loading_check === null)
                                    <span class="badge rounded-pill bg-danger">Open</span>
                                    @else
                                    <b>{{ $part->qty_loading_check }}/{{$part->total_label }}</b>
                                    @endif
                                </td>

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
