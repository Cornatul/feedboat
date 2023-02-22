@extends('marketing::layouts.app')

@section('title', __('Imported Feeds'))

@section('heading')
    {{ __('Imported Feeds') }}
@endsection

@section('content')
    <ul class="nav nav-pills mb-4">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('feeds.imported') ? 'active'  : '' }}"
               href="{{ route('feeds.imported') }}">{{ __('Import Feeds') }}</a>
        </li>
    </ul>
    <div id="imported"></div>
@endsection

@push('js')
    <script src="{{ asset('js/imported.js') }}"></script>
@endpush
