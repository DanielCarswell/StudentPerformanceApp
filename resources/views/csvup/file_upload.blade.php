@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">File Upload</div>
                <div class="card-body">
                <form method="POST" action="{{ route('file.upload') }}" aria-label="{{ __('Upload') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="title" class="col-sm-4 col-form-label text-md-right">{{ __('Title') }}</label>
                            <div class="col-md-6">
                                <input type="file" name="logo" />
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection