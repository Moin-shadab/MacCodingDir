<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Module;
use App\Models\Page;
use App\Models\UserPermission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->is_admin) {
                abort(403, 'Unauthorized');
            }
            return $next($request);
        });
    }

    // Users Management
    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function createUser(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'is_active' => 'boolean',
            'is_admin' => 'boolean',
        ]);

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'is_active' => $request->boolean('is_active', true),
            'is_admin' => $request->boolean('is_admin', false),
        ]);

        return redirect()->route('admin.users')->with('success', 'User created.');
    }

    public function toggleActive($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();
        return redirect()->route('admin.users')->with('success', 'User status updated.');
    }

    // Modules Management
    public function modules()
    {
        $modules = Module::with('pages')->get();
        return view('admin.modules', compact('modules'));
    }

    public function createModule(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:modules',
            'description' => 'nullable',
        ]);

        $module = Module::create($request->only('name', 'description'));

        // Create module folder
        $folderPath = resource_path("views/modules/{$module->name}");
        File::makeDirectory($folderPath, 0755, true, true);

        return redirect()->route('admin.modules')->with('success', 'Module created.');
    }

    // Pages Management
    public function createPage(Request $request, $moduleId)
    {
        $request->validate([
            'name' => 'required|unique:pages',
            'description' => 'nullable',
        ]);

        $module = Module::findOrFail($moduleId);
        $page = Page::create(['module_id' => $moduleId, 'name' => $request->name, 'description' => $request->description]);

        // Create blank view file
        $viewPath = resource_path("views/modules/{$module->name}/{$page->name}.blade.php");
        File::put($viewPath, "<h1>{$page->name} Page</h1>\n<p>Content for {$module->name} module's {$page->name} page.</p>");

        return redirect()->route('admin.modules')->with('success', 'Page created.');
    }

    // Permissions Management
    public function permissions($userId)
    {
        $user = User::findOrFail($userId);
        $modules = Module::with('pages')->get();
        $permissions = UserPermission::where('user_id', $userId)->get()->keyBy(function ($item) {
            return $item->module_id . '-' . ($item->page_id ?? 'module');
        });
        return view('admin.permissions', compact('user', 'modules', 'permissions'));
    }

    public function assignPermission(Request $request, $userId)
    {
        $request->validate([
            'module_id' => 'required|exists:modules,id',
            'page_id' => 'nullable|exists:pages,id',
            'can_view' => 'boolean',
            'can_create' => 'boolean',
            'can_update' => 'boolean',
            'can_delete' => 'boolean',
        ]);

        UserPermission::updateOrCreate(
            ['user_id' => $userId, 'module_id' => $request->module_id, 'page_id' => $request->page_id],
            [
                'can_view' => $request->boolean('can_view'),
                'can_create' => $request->boolean('can_create'),
                'can_update' => $request->boolean('can_update'),
                'can_delete' => $request->boolean('can_delete'),
            ]
        );

        return redirect()->route('admin.permissions', $userId)->with('success', 'Permissions updated.');
    }
}