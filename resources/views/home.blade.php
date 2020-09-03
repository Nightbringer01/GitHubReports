@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row">
                    <div class="card col-2 p-0">
                        <div class="card-header">{{ __('Actions') }}</div>
                        <div class="card-body p-0">
                            <table class="table p-0 m-0 table-hover">
                                <tr class="border-bottom">
                                    <td class="w-100 m-0 p-0">
                                        <a class="nav-link text-dark"
                                            href="{{ route('loadrepos') }}">{{ __('Reload Repos') }}</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-10 p-0">
                        <div class="card">
                            <div class="card-header">{{ __('User Repos') }}</div>
                            <div class="card-body pt-1">
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                <table class="table table-striped">
                                    <tr>
                                        <td>Name</td>
                                        <td>User</td>
                                    </tr>
                                    @if (count($repos) > 0)
                                        @foreach ($repos as $repo)
                                            @if (!in_array((explode('/',$repo->name)[0]),
                                            $organizations->pluck('name')->toArray()))
                                            <tr>
                                                <td>{{ $repo->name }}</td>
                                                <td>{{ $repo->user_id }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan=100>No Repositories Found</td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                        @if (count($organizations) > 0)
                            @foreach ($organizations as $oraganization)
                                <div class="card">
                                    <div class="card-header">{{ __($oraganization->name . ' Repos') }}</div>
                                    <div class="card-body pt-1">
                                        @if (session('status'))
                                            <div class="alert alert-success" role="alert">
                                                {{ session('status') }}
                                            </div>
                                        @endif
                                        <table class="table table-striped">
                                            <tr>
                                                <td>Name</td>
                                                <td>User</td>
                                            </tr>
                                            @if (count($repos) > 0)
                                                @foreach ($repos as $repo)
                                                    @if (explode('/', $repo->name)[0] == $oraganization->name)
                                                        <tr>
                                                            <td>{{ $repo->name }}</td>
                                                            <td>{{ $repo->user_id }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan=100>No Repositories Found</td>
                                                </tr>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
