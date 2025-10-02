@extends('layouts.app')

@section('content')
<h1>Manage Users</h1>
<table class="table">
    <thead>
        <tr>
            <th>Username</th>
            <th>Active</th>
            <th>Admin</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->username }}</td>
            <td>{{ $user->is_active ? 'Yes' : 'No' }}</td>
            <td>{{ $user->is_admin ? 'Yes' : 'No' }}</td>
            <td>
                <form action="{{ route('admin.toggleActive', $user->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-warning">Toggle Active</button>
                </form>
                <a href="{{ route('admin.permissions', $user->id) }}" class="btn btn-sm btn-info">Permissions</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<h2>Create User</h2>
<form action="{{ route('admin.createUser') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Username</label>
        <input type="text" name="username" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <div class="form-check mb-3">
        <input type="checkbox" name="is_active" class="form-check-input" checked>
        <label class="form-check-label">Active</label>
    </div>
    <div class="form-check mb-3">
        <input type="checkbox" name="is_admin" class="form-check-input">
        <label class="form-check-label">Admin</label>
    </div>
    <button type="submit" class="btn btn-primary">Create</button>
</form>
@endsection