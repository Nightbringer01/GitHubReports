@extends('layouts.app')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="card col-8 p-0">
            <div class="card-header">
                Edit
            </div>
            <div class="card-body">
                <form action="{{ route('repo.update', ['repo' => $repo->id]) }}" method="POST">
                    @csrf
                    {{ method_field('put') }}

                    <div class="form-group">
                        <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="Message to be shown when user creates an issue."></i>
                        <label for="message">Message: </label>
                        <textarea class="ckeditor form-control" name="message" id="">{{$repo->message}}</textarea>
                    </div>

                    <div class="form-group">
                        <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="Message to be shown after user creates an issue."></i>
                        <label for="post_report_message">Post Report Message: </label>
                        <textarea class="ckeditor form-control" name="post_report_message" id="">{{$repo->post_report_message}}</textarea>
                    </div>

                    <div class="form-group">
                        <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="issue label when reported to github"></i>
                        <label for="default_issue_label">Issue Label: </label>
                        <input type="text" class="form-control" name="default_issue_label" id="" value="{{$repo->default_issue_label}}">
                    </div>

                    <button class="btn btn-danger" type="submit">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
