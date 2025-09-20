<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <meta name="viewport" content="width=device-width, initial-scale=0.5"> --}}
    <title>Pendoman Packing</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <!-- Favicons -->
    <link href="{{ asset('assets/img/icon-kbi.png') }}" rel="icon">
    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet"
        integrity="sha384-GtSAFlYp4zEO1Ypr2GGo..." crossorigin="anonymous">
    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/packing.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/loader.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<style>
    .fade-out {
        opacity: 0;
        transition: opacity 0.5s ease-out;
    }

    @media screen and (min-width: 1920px) {
        .swal-responsive {
            font-size: 2.5rem;
            /* Ukuran teks untuk layar besar */
        }

        .swal2-popup {
            font-size: 2rem;
            width: 100%;
        }
    }
</style>

<body>
    {{-- loader --}}
    <div class="loader" id="loader">
        <div class="truckWrapper">
            <div class="truckBody">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 198 93" class="trucksvg">
                    <path stroke-width="3" stroke="#282828" fill="#F83D3D"
                        d="M135 22.5H177.264C178.295 22.5 179.22 23.133 179.594 24.0939L192.33 56.8443C192.442 57.1332 192.5 57.4404 192.5 57.7504V89C192.5 90.3807 191.381 91.5 190 91.5H135C133.619 91.5 132.5 90.3807 132.5 89V25C132.5 23.6193 133.619 22.5 135 22.5Z">
                    </path>
                    <path stroke-width="3" stroke="#282828" fill="#7D7C7C"
                        d="M146 33.5H181.741C182.779 33.5 183.709 34.1415 184.078 35.112L190.538 52.112C191.16 53.748 189.951 55.5 188.201 55.5H146C144.619 55.5 143.5 54.3807 143.5 53V36C143.5 34.6193 144.619 33.5 146 33.5Z">
                    </path>
                    <path stroke-width="2" stroke="#282828" fill="#282828"
                        d="M150 65C150 65.39 149.763 65.8656 149.127 66.2893C148.499 66.7083 147.573 67 146.5 67C145.427 67 144.501 66.7083 143.873 66.2893C143.237 65.8656 143 65.39 143 65C143 64.61 143.237 64.1344 143.873 63.7107C144.501 63.2917 145.427 63 146.5 63C147.573 63 148.499 63.2917 149.127 63.7107C149.763 64.1344 150 64.61 150 65Z">
                    </path>
                    <rect stroke-width="2" stroke="#282828" fill="#FFFCAB" rx="1" height="7" width="5"
                        y="63" x="187"></rect>
                    <rect stroke-width="2" stroke="#282828" fill="#282828" rx="1" height="11" width="4"
                        y="81" x="193"></rect>
                    <rect stroke-width="3" stroke="#282828" fill="#DFDFDF" rx="2.5" height="90" width="121"
                        y="1.5" x="6.5"></rect>
                    <rect stroke-width="2" stroke="#282828" fill="#DFDFDF" rx="2" height="4" width="6"
                        y="84" x="1"></rect>
                </svg>
            </div>
            <div class="truckTires">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 30 30" class="tiresvg">
                    <circle stroke-width="3" stroke="#282828" fill="#282828" r="13.5" cy="15" cx="15">
                    </circle>
                    <circle fill="#DFDFDF" r="7" cy="15" cx="15"></circle>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 30 30" class="tiresvg">
                    <circle stroke-width="3" stroke="#282828" fill="#282828" r="13.5" cy="15" cx="15">
                    </circle>
                    <circle fill="#DFDFDF" r="7" cy="15" cx="15"></circle>
                </svg>
            </div>
            <div class="road"></div>

            <svg xml:space="preserve" viewBox="0 0 453.459 453.459" xmlns:xlink="http://www.w3.org/1999/xlink"
                xmlns="http://www.w3.org/2000/svg" id="Capa_1" version="1.1" fill="#000000" class="lampPost">
                <path d="M252.882,0c-37.781,0-68.686,29.953-70.245,67.358h-6.917v8.954c-26.109,2.163-45.463,10.011-45.463,19.366h9.993
                c-1.65,5.146-2.507,10.54-2.507,16.017c0,28.956,23.558,52.514,52.514,52.514c28.956,0,52.514-23.558,52.514-52.514
                c0-5.478-0.856-10.872-2.506-16.017h9.992c0-9.354-19.352-17.204-45.463-19.366v-8.954h-6.149C200.189,38.779,223.924,16,252.882,16
                c29.952,0,54.32,24.368,54.32,54.32c0,28.774-11.078,37.009-25.105,47.437c-17.444,12.968-37.216,27.667-37.216,78.884v113.914
                h-0.797c-5.068,0-9.174,4.108-9.174,9.177c0,2.844,1.293,5.383,3.321,7.066c-3.432,27.933-26.851,95.744-8.226,115.459v11.202h45.75
                v-11.202c18.625-19.715-4.794-87.527-8.227-115.459c2.029-1.683,3.322-4.223,3.322-7.066c0-5.068-4.107-9.177-9.176-9.177h-0.795
                V196.641c0-43.174,14.942-54.283,30.762-66.043c14.793-10.997,31.559-23.461,31.559-60.277C323.202,31.545,291.656,0,252.882,0z
                M232.77,111.694c0,23.442-19.071,42.514-42.514,42.514c-23.442,0-42.514-19.072-42.514-42.514c0-5.531,1.078-10.957,3.141-16.017
                h78.747C231.693,100.736,232.77,106.162,232.77,111.694z"></path>
            </svg>
        </div>
    </div>
    {{-- loadder  --}}
    <script>
        $(window).on('load', function() {
            $('.loading').addClass('hidden');
            setTimeout(() => {
                $('.loading').remove();
            }, 1000);
        });
    </script>
    <section class="section">
        <div class="navbar d-flex justify-content-between align-items-center mb-1 p-2  rounded ">
            <h5 class="card-title " style="font-size: 20px; font-weight: bold; color: #ffff;">
                <i class="fas fa-box-open me-1"></i> Panduan Packing
                @if (isset($orderDetails) && !empty($orderDetails['order']))
                    <p class="colom mt-1" style="font-size: 11px; margin-bottom: -1px; color: #e67e22;">
                        <i class="fas fa-file-invoice"></i>&nbsp;&nbsp;Cust&nbsp;:&nbsp;
                        <strong
                            style="width: 5px; font-size: 14px; color: #e0e0e0; padding: 1px; text-transform: uppercase;">
                            &nbsp;{{ $orderDetails['order']->customer->name ?? 'Not Available' }}
                        </strong>
                        &nbsp;|&nbsp;PO No&nbsp;:&nbsp;
                        <strong
                            style="width: 5px; font-size: 14px; color: #e0e0e0; padding: 1px; text-transform: uppercase;">
                            &nbsp;{{ $orderDetails['order']->P_order ?? 'Not Available' }}
                        </strong>
                        </br>
                        <i class="fas fa-calendar-alt"></i>&nbsp;&nbsp;Delivery Date&nbsp;:&nbsp;
                        <strong style="color: #bdc3c7; font-size: 16px;">
                            {{ \Carbon\Carbon::parse($orderDetails['order']->delivery_date ?? now())->format('d-m-Y') }}
                        </strong>
                    </p>
                @else
                    <p class="text-center" style="color: #e74c3c;">Data order tidak tersedia.</p>
                @endif

            </h5>
            <!-- Audio Elements -->
            <audio id="notFoundSound" src="{{ asset('assets/audio/no_order.m4a') }}" preload="auto" muted></audio>
            <audio id="berhasilSound" src="{{ asset('assets/audio/packing_berhasil.m4a') }}" preload="auto"
                muted></audio>
            <audio id="errorSound" src="{{ asset('assets/audio/error-170796.mp3') }}" preload="auto" muted></audio>
            <audio id="bedaCustSound" src="{{ asset('assets/audio/ai-no_cust_berbeda.m4a') }}" preload="auto"
                muted></audio>


            <!-- Alert Elements -->
            @if (session('success'))
                <div id="alertSuccess" class="alert alert-success alert-dismissible fade show mt-1 p-1"
                    role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('notfound'))
                <div id="alertNotFound" class="alert alert-danger alert-dismissible fade show mt-1 p-1"
                    role="alert">
                    {{ session('notfound') }}
                </div>
            @endif
            @if (session('bedacust'))
                <div id="alertBedaCust" class="alert alert-danger alert-dismissible fade show mt-1 p-1"
                    role="alert">
                    {{ session('bedacust') }}
                </div>
            @endif
            @if (session('error'))
                <div id="alertError" class="alert alert-danger alert-dismissible fade show mt-1 p-1" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('berhasil'))
                <div id="alertBerhasil" class="alert alert-success alert-dismissible fade show mt-1 p-1"
                    role="alert">
                    {{ session('berhasil') }}
                </div>
            @endif
            @if (session('sudahall'))
                <div id="alerterror" class="alert alert-info alert-dismissible fade show mt-1 p-1" role="alert">
                    {{ session('sudahall') }}
                </div>
            @endif
            <div class="text-end">
                <small class="text-muted d-block">
                    <strong style="color:#1abc9c;">{{ $user->first_name }} {{ $user->last_name }}</strong>
                    <i class="fas fa-user me-1" style="color:#1abc9c;"></i>
                </small>
                <small class="text-muted d-block">
                    <strong style="color: #bdc3c7">
                        @if (!empty($user->last_login) && $user->last_login instanceof \Carbon\Carbon)
                            {{ $user->last_login->format('d M Y, H:i:s') }}
                        @else
                            {{ $user->last_login ?? 'Belum login' }}
                        @endif
                    </strong>
                </small>
            </div>

        </div>
        {{-- form --}}
        <div class="row">
            <!-- Form Card -->
            <div class="col-md-2 p-2 mt-1" style="margin-bottom: -49px;">
                <div class="card">
                    <div class="card-body mt-1">
                        <form class="row g-1" action="{{ route('packing.manage', Auth::id()) }}" method="POST"
                            novalidate id="autoSubmitForm">
                            @csrf
                            <div class="col-12 mt-3 mb-2">
                                <div class="input-group" style="margin-bottom: -3px;margin-top:8px">
                                    <input type="text" name="part_number" class="form-control"
                                        id="partNumberInput"placeholder="Scan Customer No" required autofocus>
                                </div>
                            </div>
                            <input type="hidden" name="action" value="show" id="actionField">
                        </form>
                    </div>
                </div>
            </div>
            <!-- part_name+dll -->
            <div class="col-md-5 p-2" style="margin-bottom: -46px;">
                <div class="card">
                    @if (isset($orderDetails) && !empty($orderDetails['order']))
                        <div class="card-body mt-3 p-2" style="margin-bottom: 2px;">
                            <div class="table-responsive">
                                <div class="d-flex justify-content-center" style="gap: 15px;">
                                    <!-- Set gap for space between tables -->
                                    <div style="margin-right:auto; width:100%;">
                                        <!-- Adjust margin and set width -->
                                        <table class="table table-bordered text-center align-middle"
                                            style="border: 3px solid black; margin-bottom: 2px; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th colspan="6"
                                                        style="font-size: 9px; border: 3px solid black; padding: 10px; text-align: center; vertical-align: middle; padding: 2px;">
                                                        Part Number
                                                    </th>
                                                    <th colspan="6"
                                                        style="font-size: 9px; border: 3px solid black; text-align: center; vertical-align: middle; padding: 2px;">
                                                        Part Name
                                                    </th>
                                                    <th colspan="6"
                                                        style="font-size: 9px; border: 3px solid black; text-align: center; vertical-align: middle; padding:2px;">
                                                        Part No Customer
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="6"
                                                        style="border: 3px solid black; text-align: center; vertical-align: middle; padding: 2px;">
                                                        <strong style="font-size: 13px;">
                                                            {{ $orderDetails['order']->part->P_No ?? '' }}
                                                        </strong>
                                                    </td>
                                                    <td colspan="6"
                                                        style="border: 3px solid black; text-align: center; vertical-align: middle; padding: 2px;">
                                                        <strong style="font-size: 13px;">
                                                            {{ $orderDetails['order']->part->P_Name ?? '' }}
                                                        </strong>
                                                    </td>
                                                    <td colspan="6"
                                                        style="border: 3px solid black; text-align: center; vertical-align: middle; padding: 2px;">
                                                        <strong style="font-size: 13px;">
                                                            {{ $orderDetails['order']->P_no_cus ?? '' }}
                                                        </strong>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="p-2 text-center">
                            <p>Data order tidak tersedia.</p>
                        </div>
                    @endif
                </div>
            </div>
            {{-- qty --}}
            <div class="col-md-5 p-2" style="margin-bottom: -46px;">
                <div class="card">
                    @if (isset($orderDetails) && !empty($orderDetails['order']))
                        <div class="card-body mt-2 p-2" style="margin-bottom: -4px;">
                            <div class="table-responsive">
                                <div class="d-flex justify-content-center" style="gap: 10px;">
                                    <!-- Set gap for space between tables -->
                                    <div style="margin-right: auto; width:100%;">
                                        <!-- Adjust margin and set width -->
                                        <table class="table table-bordered text-center align-middle"
                                            style="border: 3px solid black; margin-bottom: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th colspan="6"
                                                        style="font-size: 12px; border: 3px solid black; padding: 1px; text-align: center; vertical-align: middle;">
                                                        <i class="fas fa-cubes"></i>&nbsp;Quantity Order<br>(pcs)
                                                    </th>
                                                    <th colspan="6"
                                                        style="font-size: 12px; border: 3px solid black; padding: 1px; text-align: center; vertical-align: middle;">
                                                        <i class="fas fa-check-circle"></i>&nbsp;Qty Prepared<br>(pcs)
                                                    </th>
                                                    <th colspan="6"
                                                        style="font-size: 12px; border: 3px solid black; padding: 1px; text-align: center; vertical-align: middle;">
                                                        <i class="fas fa-times-circle"></i>&nbsp;Outstanding<br>(pcs)
                                                    </th>
                                                    <th colspan="6"
                                                        style="font-size: 12px; border: 3px solid black; padding: 1px; text-align: center; vertical-align: middle;">
                                                        <i
                                                            class="fas fa-exclamation-triangle"></i>&nbsp;OverDue<br>(Days)
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="6"
                                                        style="border: 3px solid black; text-align: center; vertical-align: middle; padding: 2px;">
                                                        <strong style="width: 5px; font-size:16px;">
                                                            {{ $orderDetails['order']->Qty }}
                                                        </strong>
                                                    </td>
                                                    <td colspan="6"
                                                        style="border: 3px solid black; text-align: center; vertical-align: middle; padding: 2px;">
                                                        @php
                                                            $qtyPrepared = \App\Models\Planning::where(
                                                                'id_order',
                                                                $orderDetails['order']->id,
                                                            )->count();
                                                        @endphp
                                                        <strong style="width: 5px; font-size:16px; color: blue;">
                                                            {{ $qtyPrepared ?? '' }}
                                                        </strong>
                                                    </td>
                                                    <td colspan="6"
                                                        style="border: 3px solid black; text-align: center; vertical-align: middle; padding: 2px;">
                                                        @php
                                                            $outStanding = $orderDetails['order']->Qty - $qtyPrepared;
                                                        @endphp
                                                        <strong style="width: 5px; font-size:16px; color: red;">
                                                            {{ $outStanding >= 0 ? $outStanding : '' }}
                                                        </strong>
                                                    </td>
                                                    <td colspan="6"
                                                        style="border: 3px solid black; text-align: center; vertical-align: middle; padding: 2px;">
                                                        @php
                                                            $etaWHNew = \Carbon\Carbon::parse(
                                                                $orderDetails['order']->delivery_date,
                                                            );
                                                            $now = \Carbon\Carbon::now();
                                                            $daysOverdue = $now->greaterThan($etaWHNew)
                                                                ? $now->diffInDays($etaWHNew)
                                                                : 0;
                                                        @endphp
                                                        <strong
                                                            style="width: 5px; font-size:16px; color: {{ $daysOverdue > 0 ? 'orange' : 'green' }};">
                                                            {{ $daysOverdue > 0 ? '-' . $daysOverdue : '0' }}
                                                        </strong>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="p-2 text-center">
                            <p>Data order tidak tersedia.</p>
                        </div>
                    @endif
                </div>
            </div>
            {{-- inner dll --}}
            <div class="table-inner-outer col-md-12 p-3" style="margin-top:2px">
                @if (isset($orderDetails) && count($orderDetails) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle" style="border: 2px solid black;">
                            <thead>
                                <tr>
                                    <th colspan="3"
                                        style="border: 2px solid black; font-size: 11px; padding: 1px;">
                                        Image Part</th>
                                    <th colspan="4"
                                        style="font-size: 11px; border: 2px solid black; text-align: center; vertical-align: middle; padding: 1px;">
                                        Packing Spec (Inner)</th>
                                    <th colspan="4"
                                        style="font-size: 11px; border: 2px solid black; text-align: center; vertical-align: middle; padding: 1px;">
                                        Packing Spec (Outer)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="3" rowspan="8"
                                        style="border: 2px solid black; text-align: center;">
                                        <div
                                            style="display: flex; flex-direction: column; align-items: center; vertical-align: middle; padding: 1px;">
                                            @if ($orderDetails['order']->part->img_p)
                                                <img src="{{ asset($orderDetails['order']->part->img_p) }}"
                                                    class="img-fluid img-thumbnail" loading="lazy"
                                                    style="width: 360px; height: 420px; object-fit: fill; box-shadow: 6px 6px 15px rgba(0, 0, 0, 0.5); margin-top: 5px;">
                                            @else
                                                <div
                                                    style="text-align: center; color: red; font-size: 16px;margin-bottom: 10px;margin-top: 10px;">
                                                    <i class="fas fa-exclamation-triangle"
                                                        style="font-size: 30px; margin-bottom: 10px;"></i> <br>
                                                    <strong>Gambar belum di-upload</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    <td colspan="4" rowspan="3"
                                        style="border: 2px solid black; text-align: center;">
                                        <div
                                            style="display: flex; flex-direction: column; align-items: center; vertical-align: middle; padding: 1px;">
                                            @if ($orderDetails['order']->innerPart->Image_ip)
                                                <img src="{{ asset($orderDetails['order']->innerPart->Image_ip) }}"
                                                    class="img-fluid img-thumbnail" loading="lazy"
                                                    style="width: 350px; height: 180px; object-fit: fill; box-shadow: 6px 6px 15px rgba(0, 0, 0, 0.5); margin-top: 2px;">
                                            @else
                                                <div
                                                    style="text-align: center; color: red; font-size: 16px;margin-bottom: 50px;margin-top: 50px;">
                                                    <i class="fas fa-exclamation-triangle"
                                                        style="font-size: 40px; margin-bottom: 10px;"></i> <br>
                                                    <strong>Gambar belum di-upload</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td colspan="4" rowspan="3"
                                        style="border: 2px solid black; text-align: center;">
                                        <div
                                            style="display: flex; flex-direction: column; align-items: center; vertical-align: middle; padding: 1px;">
                                            @if ($orderDetails['order']->outerPart->Image_op)
                                                <img src="{{ asset($orderDetails['order']->outerPart->Image_op) }}"
                                                    class="img-fluid img-thumbnail" loading="lazy"
                                                    style="width: 350px; height: 180px; object-fit: fill; box-shadow: 6px 6px 15px rgba(0, 0, 0, 0.5); margin-top: 5px;">
                                            @else
                                                <div
                                                    style="text-align: center; color: red; font-size: 16px;margin-bottom: 50px;margin-top: 50px;">
                                                    <i class="fas fa-exclamation-triangle"
                                                        style="font-size: 40px; margin-bottom: 10px;"></i> <br>
                                                    <strong>Gambar belum di-upload</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr></tr>
                                <tr></tr>
                                <tr
                                    style="border: 2px solid black; text-align: center; vertical-align: middle; padding: 1px;">
                                    <th style="border: 2px solid black; font-size: 8px; padding: 1px;">Size</th>
                                    <th style="border: 2px solid black; font-size: 8px; padding: 1px;">Logo</th>
                                    <th style="border: 2px solid black; font-size: 8px; padding: 1px;">Label</th>
                                    <th style="border: 2px solid black; font-size: 8px; padding: 1px;">Pcs/Pack</th>
                                    <th style="border: 2px solid black; font-size: 8px; padding: 1px;">Size</th>
                                    <th style="border: 2px solid black; font-size: 8px; padding: 1px;">Logo</th>
                                    <th style="border: 2px solid black; font-size: 8px; padding: 1px;">Label</th>
                                    <th style="border: 2px solid black; font-size: 8px; padding: 1px;">Pcs/Pack</th>
                                </tr>
                                <tr style="border: 2px solid black; text-align: center; font-size: 10px;">
                                    <td style="border: 2px solid black;text-align: center;">
                                        {{ $orderDetails['order']->innerPart->size_ip ?? 'N/A' }}
                                        <span style="text-transform: none; font-size: 9px;">mm</span>
                                    </td>
                                    <td style="border: 2px solid black;text-align: center;">
                                        {{ $orderDetails['order']->innerPart->logo_ip ?? 'N/A' }}
                                    </td>
                                    <td style="border: 2px solid black;text-align: center;">
                                        {{ $orderDetails['order']->innerPart->label_ip ?? 'N/A' }}
                                    </td>
                                    <td style="border: 2px solid black;text-align: center;">
                                        {{ $orderDetails['order']->innerPart->Qty_ip ?? 'N/A' }}
                                    </td>
                                    <td style="border: 2px solid black;text-align: center;">
                                        {{ $orderDetails['order']->outerPart->size_op ?? 'N/A' }}
                                        <span style="text-transform: none; font-size: 9px;">mm</span>
                                    </td>
                                    <td style="border: 2px solid black;text-align: center;">
                                        {{ $orderDetails['order']->outerPart->logo_op ?? 'N/A' }}
                                    </td>
                                    <td style="border: 2px solid black;text-align: center;">
                                        {{ $orderDetails['order']->outerPart->label_op ?? 'N/A' }}
                                    </td>
                                    <td style="border: 2px solid black;text-align: center;">
                                        {{ $orderDetails['order']->outerPart->Qty_op ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="4" style="font-size: 11px;border: 2px solid black; padding: 1px;">
                                        Label Image</th>
                                    <th colspan="3" style="font-size: 11px;border: 2px solid black; padding: 1px;">
                                        Posisi Penempelan Label</th>
                                    <th colspan="1" style="font-size: 11px;border: 2px solid black; padding: 1px;">
                                        Catatan</th>
                                </tr>
                                <tr>
                                    <td colspan="4" style="border: 2px solid black; text-align: center;">
                                        <div
                                            style="display: flex; flex-direction: column; align-items: center; vertical-align: middle; padding: 1px;">

                                            @if ($orderDetails['order']->part->lbl_img)
                                                <img src="{{ asset($orderDetails['order']->part->lbl_img) }}"
                                                    class="img-fluid img-thumbnail" loading="lazy"
                                                    style="width: 310px; height: 150px; object-fit: fill; cursor: pointer; box-shadow: 6px 6px 15px rgba(0, 0, 0, 0.5);">
                                            @else
                                                <div
                                                    style="text-align: center; color: red; font-size: 16px;margin-bottom: 30px;margin-top: 30px;">
                                                    <i class="fas fa-exclamation-triangle"
                                                        style="font-size: 40px; margin-bottom: 10px;"></i> <br>
                                                    <strong>Gambar belum di-upload</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td colspan="3" style="border: 2px solid black; text-align: center;">
                                        @if ($orderDetails['order']->part->pos_label)
                                            <img src="{{ asset($orderDetails['order']->part->pos_label) }}"
                                                class="img-fluid img-thumbnail" loading="lazy"
                                                style="width: 310px; height: 150px; object-fit: fill; cursor: pointer; box-shadow: 6px 6px 15px rgba(0, 0, 0, 0.5);">
                                        @else
                                            <div
                                                style="text-align: center; color: red; font-size: 16px;margin-bottom: 30px;margin-top: 30px;">
                                                <i class="fas fa-exclamation-triangle"
                                                    style="font-size: 40px; margin-bottom: 10px;"></i> <br>
                                                <strong>Gambar belum di-upload</strong>
                                            </div>
                                        @endif
                                    </td>
                                    <td colspan="1" style="border: 2px solid black;text-align: center;">
                                        <strong style="font-size: 10px; vertical-align: middle; padding: 1px;">
                                            {{ $orderDetails['order']->catatan ?? 'Not Available' }}
                                        </strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>Data tidak ditemukan.</p>
                @endif
            </div>
            {{-- end --}}
        </div>
    </section>
    <script>
        // Fungsi untuk memfokus kembali input jika form telah dikirim
        document.addEventListener('DOMContentLoaded', function() {
            const partNumberInput = document.getElementById('partNumberInput');
            partNumberInput.focus(); // Fokus pada input saat halaman dimuat

            // Menjaga fokus tetap pada input meskipun mengklik di luar form
            document.addEventListener('click', function(event) {
                if (event.target !== partNumberInput) {
                    partNumberInput.focus();
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const keepSessionAlive = () => {
                fetch('{{ route('keep.session.alive') }}', {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Session refresh failed');
                        }
                        return response.json();
                    })
                    .then(data => console.log(data.message))
                    .catch(error => {
                        console.error('Session expired:', error);
                        alert('Session expired. Please refresh the page.');
                        window.location.reload();
                    });
            };

            // Refresh session every 5 minutes (300000 ms)
            setInterval(keepSessionAlive, 300000);

            // Handle auto-close for alerts
            setTimeout(() => {
                document.querySelectorAll('.alert').forEach(alert => {
                    alert.classList.add('fade-out');
                    setTimeout(() => alert.remove(), 500);
                });
            }, 5000);
        });
    </script>
    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    {{-- sesion reload with ajax --}}
    <!-- Scripts -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Fungsi untuk menghentikan semua audio
            function stopAllAudio() {
                const audios = document.querySelectorAll('audio');
                audios.forEach(audio => {
                    audio.pause(); // Hentikan audio
                    audio.currentTime = 0; // Reset waktu audio ke awal
                });
            }

            // Fungsi untuk memutar audio tertentu
            function playSound(audioId) {
                stopAllAudio(); // Hentikan audio lain
                const audio = document.getElementById(audioId);
                if (audio) {
                    audio.muted = false; // Lepaskan mute sebelum memutar
                    audio.play().catch(error => {
                        console.error('Gagal memutar audio:', error);
                        showManualAudioButton(audio); // Tambahkan tombol manual jika autoplay gagal
                    });
                }
            }

            // Tambahkan tombol manual jika autoplay gagal
            function showManualAudioButton(audio) {
                const enableButton = document.createElement('button');
                enableButton.innerText = 'Aktifkan Suara';
                enableButton.style.position = 'fixed';
                enableButton.style.bottom = '10px';
                enableButton.style.right = '10px';
                enableButton.style.zIndex = 9999;
                enableButton.style.padding = '10px 20px';
                enableButton.style.background = '#1abc9c';
                enableButton.style.color = '#fff';
                enableButton.style.border = 'none';
                enableButton.style.cursor = 'pointer';
                enableButton.onclick = () => {
                    audio.play();
                    enableButton.remove(); // Hapus tombol setelah audio diputar
                };
                document.body.appendChild(enableButton);
            }

            // Logika untuk memutar audio berdasarkan alert yang aktif
            if (document.getElementById('alertBerhasil')) {
                playSound('berhasilSound');
            } else if (document.getElementById('alertNotFound')) {
                playSound('notFoundSound');
            } else if (document.getElementById('alertBedaCust')) {
                playSound('bedaCustSound');
            } else if (document.getElementById('alerterror')) {
                playSound('errorSound');
            }
        });
        // code hiden loader
        // Sembunyikan loader setelah halaman selesai dimuat
        window.addEventListener('load', function() {
            const loader = document.getElementById('loader');
            if (loader) loader.style.display = 'none';
        });
    </script>

</body>

</html>
