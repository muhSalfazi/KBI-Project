<div class="table-responsive-scroll">
    <table
        class="table table-bordered table-striped mt-2 table-hover table-sm text-center text-nowrap"
    >
        <thead class="table-light">
            <tr>
                <th>Customer</th>
                <th>Manifest</th>
                <th>Cycle</th>
                <th>Status DN/Manifest</th>
                <th>Check Surat Jalan</th>

                @if(request('loading') == 'true')
                <th>Check Loading</th>
                @endif
            </tr>
        </thead>
        <tbody>

            @if(empty($data) || $data === null || count($data) === 0)
            <tr>
                <td colspan="7" class="text-center">Tidak ada data</td>
            </tr>
            @else @foreach ($data as $d )
            <tr>
                <td>{{$d->first()->customer ?? 'N/A'}}</td>
                <td>{{$d->first()->dn_no ?? 'N/A'}}</td>
                <td>{{$d->first()->cycle ?? 'N/A'}}</td>
                <td>{{$d->first()->status_label ?? 'N/A'}}</td>
                <td>
                    @if ($d->first()->check_sj === null)
                    <b>Open</b>
                    @elseif ($d->first()->check_sj === 1)
                    <b style="color: blue">Close</b>
                    @else
                    <b>Open</b>
                    {{-- Tampilkan status apa adanya jika bukan null, OK, atau NG --}}
                    @endif
                </td>

                @if(request('loading') == 'true')
                <td>
                    @if ($d->first()->check_loading === null)
                    <b>Open</b>
                    @elseif ($d->first()->check_loading === 1)
                    <b style="color: blue">Close</b>
                    @else
                    <b>Open</b>
                    {{-- Tampilkan status apa adanya jika bukan null, OK, atau NG --}}
                    @endif
                </td>
                @endif
            </tr>
            @endforeach @endif
        </tbody>
    </table>
</div>
