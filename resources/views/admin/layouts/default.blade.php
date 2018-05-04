@extends('layouts.sidenav')

{{-- Web site Title --}}
@section('title')
    web.rentling :: @parent
@endsection

{{-- Styles --}}
@section('styles')
    @parent
    <link href="{{ elixir('css/rt.css') }}" rel="stylesheet">
@endsection

@section('nav')
    @include('admin.partials.nav')
@endsection
