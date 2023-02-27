@extends('marketing::layouts.app')

@section('title', __('Articles | Imported'))

@section('heading')
    {{ __('Article ') }}
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
                    <th>{{ __('Actions') }}</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($articles as $article)
                        <tr>
                            <td>
                                <a href="#">{{ $article->title }}</a>
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
