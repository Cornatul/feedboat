@extends('marketing::layouts.app')

@section('title', __('Feeds'))

@section('heading')
    {{ __('Feeds') }}
@endsection

@section('content')

    <div class="card">
        <div class="card-body">
            <div id="feeds">
                <form action="{{ route('feeds.search') }}" method="POST" class="form-inline mb-3 mb-md-0">
                    <input class="form-control form-control-sm" name="topic" type="text" value="{{ request('topic') }}"
                           placeholder="{{ __('Search...') }}">
                    <button type="submit" class="btn btn-light btn-md">{{ __('Search') }}</button>
                </form>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <!-- Generate table -->
            <table>
                <thead>
                <tr>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Subscribers') }}</th>
                    <th>{{ __('Description') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($results as $feed)
                    <tr>
                        <td>{{ $feed["title"] }}</td>
                        <td>{{ $feed["subscribers"] }}</td>
                        <td>{{ Str::limit(($feed["description"])) }}</td>
                        <td>
                            <a href="{{ route('feeds.import', $feed) }}" class="btn btn-sm btn-primary">
                                {{ __('Import') }}
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>



@endsection
