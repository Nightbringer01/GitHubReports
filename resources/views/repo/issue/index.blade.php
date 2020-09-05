@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card col-2 p-0">
                <div class="card-header">
                    Actions
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <a href="{{ route('repo.issue.create', ['repo' => $repo->id]) }}" class="border-bottom w-100 text-dark p-2">New Issue</a>
                    </div>
                </div>
            </div>
            <div class="card col-8 p-0">
                <div class="card-header">
                    Currently Open Issues
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        @foreach ($issues as $issue)
                            <tr>
                                <td>{{ $issue['title'] }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
