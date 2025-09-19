<div class="table-responsive-scroll">
    <table
        class="table table-bordered table-striped mt-2 table-hover table-sm text-center text-nowrap"
    >
        <thead class="table-light">
            <tr>
                <th>Customer</th>
                <th>Manifest</th>
                <th>Cycle</th>
                <th>Total Qty Pcs</th>
                <th>Status Label</th>
                <th>Scan Admin</th>
            </tr>
        </thead>
        <tbody>
            @if(empty($data) || $data === null || count($data) === 0)
            <tr>
                <td colspan="6" class="text-center">Tidak ada data</td>
            </tr>
            @else @foreach ($data as $d )
            <tr>
                <td>{{$d->first()->customer ?? 'N/A'}}</td>
                <td>{{$d->first()->dn_no ?? 'N/A'}}</td>
                <td>{{$d->first()->cycle ?? 'N/A'}} </td>
                <td>{{$d->first()->qty_pcs ?? 'N/A'}}</td>
                <td>{{$d->first()->status_label ?? 'N/A'}}</td>
                <td>
                    <b>{{$d->first()->status ?? 'N/A'}}</b>
                </td>
            </tr>
            @endforeach @endif
        </tbody>
    </table>
</div>
