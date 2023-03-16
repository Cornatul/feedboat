@extends('marketing::layouts.app')

@section('title', __('Imported Feeds'))

@section('heading')
    {{ __('Imported Feeds') }}
@endsection

@section('content')
    <!-- Insert here a partials !-->
    @include('feeds::partials.nav')


    <div id="app" class="card">
        <div class="card-table table-responsive">

            <x-rpd::card>
                <x-rpd::table title="List Feeds" :items="$feeds">
                    <x-slot name="filters">
                        <x-rpd::input col="col" model="search"  placeholder="search..." />
                    </x-slot>

                    <x-slot name="buttons">

                    </x-slot>

                    <table class="table">
                        <thead>
                        <tr>
                            <th>
                                <x-rpd::sort model="id" label="id" />
                            </th>
                            <th>
                                <x-rpd::sort model="title" label="title" />
                            </th>
                            <th>description</th>
                            <th>status</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($feeds as $feed)
                                <tr>
                                    <td>
                                        <a href="#">{{ $feed->id }}</a>
                                    </td>
                                    <td>{{ $feed->title }}</td>
                                    <td>{{ $feed->description }}</td>
                                    <td>{{ $feed->sync }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </x-rpd::table>
            </x-rpd::card>
        </div>
    </div>
    <script>
        window._locale = '{{ app()->getLocale() }}';
        window.livewire_app_url = '/';
    </script>
@endsection
