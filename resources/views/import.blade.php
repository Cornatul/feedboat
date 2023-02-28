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

        <div class="card-table table-responsive p-5">
            <p>
                Please provide a OPML file to import your feeds.
            </p>
            <form action="{{ route('feeds.import.store') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                @csrf

                <div class="form-group row">
                    <label for="opml" class="col-sm-2 col-form-label">OPML File</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control-file" id="opml" name="file" accept=".opml">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary">{{ __('Upload') }}</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection
