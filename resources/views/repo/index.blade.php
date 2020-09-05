@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
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
                                @include('repo.tpl.table', ['repos' => $repos, 'organizations' => $organizations, 'nonorg'
                                => true])
                            </div>
                        </div>
                        @if (count($organizations) > 0)
                            @foreach ($organizations as $organization)
                                <div class="card">
                                    <div class="card-header">{{ __($organization->name . ' Repos') }}</div>
                                    <div class="card-body pt-1">
                                        @if (session('status'))
                                            <div class="alert alert-success" role="alert">
                                                {{ session('status') }}
                                            </div>
                                        @endif
                                        @include('repo.tpl.table', ['repos' => $repos, 'organization' => $organization, 'nonorg'
                                        => false])
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
