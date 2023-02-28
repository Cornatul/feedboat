@extends('marketing::layouts.app')

@section('title', __('Feeds'))

@section('heading')
    {{ __('Feeds') }}
@endsection

@section('content')
    @include('feeds::partials.nav')
    <div id="feeds"></div>
@endsection


<!-- Todo do move this  to a partials ! or any other logic !-->

@push('js')
    <script src="{{ asset('js/feeds.js') }}"></script>
@endpush
