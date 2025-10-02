@extends('layouts.app')

@section('content')
<h1>Permissions for {{ $user->username }}</h1>
<form action="{{ route('admin.assignPermission', $user->id) }}" method="POST">
    @csrf
    @foreach($modules as $module)
        <h3>Module: {{ $module->name }}</h3>
        <!-- Module-level perms -->
        <div class="row mb-3">
            <div class="col">
                <strong>Module Level</strong>
                <input type="hidden" name="module_id" value="{{ $module->id }}">
                <input type="hidden" name="page_id" value="">
                @php $key = $module->id . '-module'; @endphp
                <div class="form-check">
                    <input type="checkbox" name="can_view" {{ optional($permissions[$key] ?? null)->can_view ? 'checked' : '' }}>
                    <label>View</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="can_create" {{ optional($permissions[$key] ?? null)->can_create ? 'checked' : '' }}>
                    <label>Create</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="can_update" {{ optional($permissions[$key] ?? null)->can_update ? 'checked' : '' }}>
                    <label>Update</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="can_delete" {{ optional($permissions[$key] ?? null)->can_delete ? 'checked' : '' }}>
                    <label>Delete</label>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">Save Module Perms</button>
            </div>
        </div>

        @foreach($module->pages as $page)
            <div class="row mb-3">
                <div class="col">
                    <strong>Page: {{ $page->name }}</strong>
                    <input type="hidden" name="module_id" value="{{ $module->id }}">
                    <input type="hidden" name="page_id" value="{{ $page->id }}">
                    @php $key = $module->id . '-' . $page->id; @endphp
                    <div class="form-check">
                        <input type="checkbox" name="can_view" {{ optional($permissions[$key] ?? null)->can_view ? 'checked' : '' }}>
                        <label>View</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="can_create" {{ optional($permissions[$key] ?? null)->can_create ? 'checked' : '' }}>
                        <label>Create</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="can_update" {{ optional($permissions[$key] ?? null)->can_update ? 'checked' : '' }}>
                        <label>Update</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="can_delete" {{ optional($permissions[$key] ?? null)->can_delete ? 'checked' : '' }}>
                        <label>Delete</label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Save Page Perms</button>
                </div>
            </div>
        @endforeach
    @endforeach
</form>
@endsection