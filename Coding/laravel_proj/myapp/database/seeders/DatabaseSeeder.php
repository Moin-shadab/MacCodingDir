<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Module;
use App\Models\Page;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'username' => 'admin',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'is_admin' => true,
            'is_active' => true,
        ]);

        // Sample dashboard module
        $module = Module::create(['name' => 'dashboard', 'description' => 'Main dashboard']);
        Page::create(['module_id' => $module->id, 'name' => 'home', 'description' => 'Home page']);

        // Create view file for dashboard
        $viewPath = resource_path('views/modules/dashboard/home.blade.php');
        if (!file_exists(dirname($viewPath))) {
            mkdir(dirname($viewPath), 0755, true);
        }
        file_put_contents($viewPath, "<h1>Welcome to Dashboard</h1>\n<p>Logged in as {{ auth()->user()->username }}</p>");
    }
}