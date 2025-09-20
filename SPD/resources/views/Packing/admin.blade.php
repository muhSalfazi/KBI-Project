@extends('layouts.app')

@section('title', 'Data Packings')

@section('content')
    <div class="pagetitle">
        <h1>Data Scan Packing</h1>
        <nav>
            <ol class="breadcrumb">
                @if (Auth::check() && Auth::user()->role == 'admin')
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                @endif
                @if (Auth::check() && Auth::user()->role == 'viewer')
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.viewer') }}">Home</a></li>
                @endif
                <li class="breadcrumb-item active">Data Packing</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    {{ session('error') }}
                </div>
            @endif

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data Scan Packing</h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered datatable">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" class="text-center">NO</th>
                                        <th scope="col" class="text-center">Purchase Order</th>
                                        <th scope="col" class="text-center">Customer Part Number</th>
                                        <th scope="col" class="text-center">Part Number</th>
                                        <th scope="col" class="text-center">Waktu Scan</th>
                                        <th scope="col" class="text-center">User</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($plannings as $planning)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $planning->order->P_order ?? 'N/A' }}</td>
                                            <td class="text-center">{{ $planning->part->cust_part_no ?? 'N/A' }}</td>
                                            <td class="text-center">{{ $planning->part->P_No ?? 'N/A' }}</td>
                                            <td class="text-center">
                                                {{ $planning->created_at->diffForHumans() }}
                                            </td>
                                            <td class="text-center">{{ $planning->user->first_name }}
                                                {{ $planning->user->last_name }}</td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
