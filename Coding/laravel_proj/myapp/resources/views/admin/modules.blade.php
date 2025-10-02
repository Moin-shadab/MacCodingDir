@extends('layouts.app')

@section('content')
<h1>Manage Modules</h1>
<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Pages</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($modules as $module)
        <tr>
            <td>{{ $module->name }}</td>
            <td>{{ $module->description }}</td>
            <td>
                @foreach($module->pages as $page)
                    {{ $page->name }} <br>
                @endforeach
            </td>
            <td>
                <!-- Add delete/update if needed -->
                <form action="{{ route('admin.createPage', $module->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <input type="text" name="name" placeholder="New Page Name" required>
                    <button type="submit" class="btn btn-sm btn-success">Add Page</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<h2>Create Module</h2>
<form action="{{ route('admin.createModule') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Description</label>
        <input type="text" name="description" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Create</button>
</form>
@endsection