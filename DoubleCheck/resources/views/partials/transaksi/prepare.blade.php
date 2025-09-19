<div class="table-responsive-scroll">
    <table
        class="table table-bordered table-striped mt-2 table-hover table-sm text-center text-nowrap"
    >
        <thead class="table-light">
            <tr>
                <th>Customer</th>
                <th>Manifest</th>
                <th>Job No</th>
                <th>Cycle</th>
                <th>Part No.</th>
                <th>Total Qty Pcs</th>
                <th>Qty Kanban</th>
                <th>Proses Scan</th>
                <th>Status Label</th>
            </tr>
        </thead>
        <tbody>
            @if(empty($data) || $data === null || count($data) === 0)
            <tr>
                <td colspan="11" class="text-center">Tidak ada data</td>
            </tr>
            @else @foreach ($data as $d )
            <tr>
                <td>{{$d->customer}}</td>
                <td>{{$d->dn_no}}</td>
                <td>{{$d->job_no}}</td>
                <td>{{$d->cycle}}</td>
                <td>{{$d->customerpart_no}}</td>
                <td>{{$d->qty_pcs}}</td>
                <td>{{$d->QtyPerKbn}}</td>
                <td>{{$d->countP}}</td>
                <td>
                    @if($d->status_label === "Open")
                    <p style="color: orange">{{$d->status_label}}</p>
                    @else
                    <p style="color: blue">{{$d->status_label}}</p>
                    @endif
                </td>
            </tr>
            @endforeach @endif
        </tbody>
    </table>
</div>
