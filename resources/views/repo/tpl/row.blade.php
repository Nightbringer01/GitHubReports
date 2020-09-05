@isset($repo)
    <tr>
        <td>{{ $repo->name }}</td>
        <td><a href={{ route('repo.edit', ['repo' => $repo->id]) }}> Edit</a></td>
        <td><a href={{ route('repo.toggleActive', ['repo' => $repo->id]) }}>{{ $repo->active ? 'Disable' : 'Enable' }}</a></td>
        <td>{!! $repo->active ? "<a href=".route('repo.issues', ['repo' => $repo->id]).">Form</a>" : '-' !!}</td>
    </tr>
@endisset
@empty($repo)
    <tr>
        <td>Name</td>
        <td></td>
        <td>Action</td>
        <td>View</td>
    </tr>
@endempty
