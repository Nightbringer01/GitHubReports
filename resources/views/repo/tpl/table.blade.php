<table class="table table-striped">
    @include('repo.tpl.row')
    @if (count($repos) > 0)
        @if ($nonorg == false)
            @foreach ($repos as $repo)
                @if (explode('/', $repo->name)[0] == $organization->name)
                    @include('repo.tpl.row', ['repo' => $repo])
                @endif
            @endforeach
        @else
            @foreach ($repos as $repo)
                @if (!in_array((explode('/',$repo->name)[0]),$organizations->pluck('name')->toArray()))
                    @include('repo.tpl.row', ['repo' => $repo])
                @endif
            @endforeach
        @endif
    @else
        <tr>
            <td colspan=100>No Repositories Found</td>
        </tr>
    @endif

</table>
