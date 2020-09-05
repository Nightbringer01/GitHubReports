@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="card">
                <div class="card-header">
                    Create Issue
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissalble fade show row">
                            <div class="col">
                                <strong>Error: </strong>
                                @foreach ($errors->all() as $error)
                                    <li>{!! $error !!}</li>
                                @endforeach
                            </div>
                            <div class="col-2">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                            </div>
                        </div>
                    @endif

                    {!! $repo->message !!}
                    <form action="{{ route('repo.issue.store', ['repo' => $repo->id]) }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name: </label>
                            <input type="text" class="form-control" name="name" id="" placeholder="(Optional)">
                        </div>

                        <div class="form-group">
                            <label for="email">Email: </label>
                            <input type="text" class="form-control" name="email" id="" placeholder="(Optional)">
                        </div>

                        <div class="form-group">
                            <label for="title">Title: </label>
                            <input type="text" class="form-control" name="title" id="">
                        </div>

                        <div class="form-group">
                            <label for="details">Details: </label>
                            <textarea class="ckeditor form-control" name="details" id=""></textarea>
                        </div>

                        <input type="submit" class="btn btn-dark float-right">

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
