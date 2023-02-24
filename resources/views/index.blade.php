@extends('marketing::layouts.app')

@section('title', __('Imported Feeds'))

@section('heading')
    {{ __('Imported Feeds') }}
@endsection

@section('content')
    <!-- Insert here a partials !-->
    @include('feeds::partials.nav')
    <!-- Cards !-->
    <div class="card">
        <div class="card-table table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Created') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($feeds as $feed)
                        <tr>
                            <td>
                                <a href="#">{{ $feed->title }}</a>
                            </td>
                            <td>
                                <a href="#">{{ $feed->created_at }}</a>
                            </td>
                            <td>
                                <a href="#">{{ $feed->status }}</a>
                            </td>
                            <td>
                                <a href="#">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
