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
                    <th>

                        <a href="{{ route('feeds.index', ['sort' => '-title']) }}">
                            <i class="fa fa-arrow-down"></i>
                        </a>

                        {{ __('Name') }}

                        <a href="{{ route('feeds.index', ['sort' => 'title']) }}">
                            <i class="fa fa-arrow-up"></i>
                        </a>

                    </th>
                    <th>{{ __('Articles') }}</th>
                    <th>
                        <a href="{{ route('feeds.index', ['sort' => '-created_at']) }}">
                            <i class="fa fa-arrow-down"></i>
                        </a>

                        {{ __('Created') }}

                        <a href="{{ route('feeds.index', ['sort' => 'created_at']) }}">
                            <i class="fa fa-arrow-up"></i>
                        </a>
                    </th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
                </thead>
                <thead>
                <tr>
                    <th>
                        <form action="{{ route('feeds.index') }}" method="GET" class="form-inline">
                            <div class="mr-2">
                                <input type="text" class="form-control" placeholder="Search..." name="filter[title]"
                                       value="{{ request('search') }}">
                            </div>

                            <button type="submit" class="btn btn-light">{{ __('Search') }}</button>

                            @if(request()->anyFilled(['search', 'status']))
                                <a href="{{ route('marketing.messages.index') }}" class="btn btn-light">{{ __('Clear') }}</a>
                            @endif
                        </form>
                    </th>
                    <th></th>
                    <th></th>
                    <th>
                        <form action="{{ route('feeds.index') }}" method="GET" class="form-inline">
                            <div class="mr-2">
                                <select name="filter[sync]" class="form-control">
                                    <option value="">{{ __('All') }}</option>
                                    <option value="completed">{{ __('Completed') }}</option>

                                </select>
                            </div>

                            <button type="submit" class="btn btn-light">{{ __('Search') }}</button>

                            @if(request()->anyFilled(['search', 'status']))
                                <a href="{{ route('marketing.messages.index') }}" class="btn btn-light">{{ __('Clear') }}</a>
                            @endif
                        </form>
                    </th>
                    <th>

                    </th>
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
                                {{ $feed->created_at }}
                            </td>
                            <td>
                                {{ $feed->sync }}
                            </td>
                            <td>
                                <a href="{{ route('feeds.destroy', [$feed->id]) }}" title="{{ __('Delete the feed') }}" class="btn btn-danger btn-sm btn-flat">
                                    <i class="fa fa-trash fa-2x"></i>
                                </a>

                                <a href="{{ route('feeds.sync', [$feed->id]) }}" title="{{ __('Syncronize the feed') }}" class="btn btn-success btn-sm btn-flat">
                                    <i class="fa fa-sync fa-2x"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('marketing::layouts.partials.pagination', ['records' => $feeds])
@endsection
