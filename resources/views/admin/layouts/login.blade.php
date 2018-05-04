@extends('layouts.login')

{{-- Web site Title --}}
@section('title')
    web.rentling :: @parent
@endsection

{{-- Styles --}}
@section('styles')
    @parent
    <link href="{{ elixir('css/rt.css') }}" rel="stylesheet">
@endsection

{{-- Scripts --}}
@section('scripts')
    @parent
    <script src="{{ elixir('js/rt.js') }}"></script>
@endsection
