@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title') :: @parent @stop

{{-- Content --}}
@section('main')
    <ul class="page-breadcrumb breadcrumb hide">
        <li>
            <a href="javascript:;">Home</a><i class="fa fa-circle"></i>
        </li>
        <li class="active">
            Tenants </li>
    </ul>
@endsection
