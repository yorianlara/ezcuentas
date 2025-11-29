@extends('layouts.master')
@section('title') Tablas de Integración | Patentes @endsection
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/libs/bootstrap-table/bootstrap-table.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('assets/libs/@fontawesome/css/all.min.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="{{ URL::asset('assets/libs/toastr/toastr.min.css') }}">
@endsection
@section('content')
@section('pagetitle') Trailers @endsection
<div class="row">
    <div class="col-12">
        <div class="page-title-box page-title-box-alt">
            <h4 class="page-title">Starter</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Minton</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Extras</a></li>
                    <li class="breadcrumb-item active">Starter</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection