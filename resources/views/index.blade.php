@extends('marketing::layouts.app')

@section('title', __('Imported Feeds'))

@section('heading')
    {{ __('Imported Feeds') }}
@endsection

@section('content')
    <!-- Insert here a partials !-->
    @include('feeds::partials.nav')



    <div class="pb-2">
        <form action="{{ route('marketing.messages.index') }}" method="GET" class="form-inline">
            <div class="mr-2">
                <input type="text" class="form-control" placeholder="Search..." name="search"
                       value="{{ request('search') }}">
            </div>

            <button type="submit" class="btn btn-light">{{ __('Search') }}</button>

            @if(request()->anyFilled(['search', 'status']))
                <a href="{{ route('marketing.messages.index') }}" class="btn btn-light">{{ __('Clear') }}</a>
            @endif
        </form>
    </div>

    <!-- Cards !-->
    <div class="card">
        <div class="card-table table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Articles') }}</th>
                    <th>{{ __('Created') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($feeds as $feed)
                        <tr>
                            <td>
                                <a href="{{ route('feeds.articles', [$feed->id]) }}">{{ $feed->title }}</a>
                            </td>
                            <td>
                                {{ $feed->articles->count() }}
                            </td>
                            <td>
                                <a href="#">{{ $feed->created_at }}</a>
                            </td>
                            <td>
                                <a href="#">{{ $feed->sync }}</a>
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
    @include('marketing::layouts.partials.pagination', ['records' => $feeds])
@endsection
