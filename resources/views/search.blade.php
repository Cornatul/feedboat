@extends('marketing::layouts.app')

@section('title', __('Feeds'))

@section('heading')
    {{ __('Feeds') }}
@endsection

@section('content')
    <ul class="nav nav-pills mb-4">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('feeds.imported') ? 'active'  : '' }}"
               href="{{ route('feeds.imported') }}">{{ __('Imported Feeds') }}</a>
        </li>
    </ul>
    <div id="feeds"></div>
@endsection

@push('js')
    <script src="{{ asset('js/feeds.js') }}"></script>
@endpush
