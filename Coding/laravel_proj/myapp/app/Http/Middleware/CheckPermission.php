<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        if (!$user->is_active) {
            Auth::logout();
            return redirect('/login')->with('error', 'Account inactive.');
        }

        $moduleName = $request->query('module', 'dashboard');
        $pageName = $request->query('page', 'home');

        $module = \App\Models\Module::where('name', $moduleName)->first();
        if (!$module) {
            return redirect('/?module=dashboard&page=home')->with('error', 'Module not found.');
        }

        $page = \App\Models\Page::where('module_id', $module->id)->where('name', $pageName)->first();

        if ($user->is_admin) {
            return $next($request);
        }

        $perm = $user->permissions()
            ->where('module_id', $module->id)
            ->where(function ($query) use ($page) {
                $query->whereNull('page_id')->orWhere('page_id', optional($page)->id);
            })
            ->where('can_view', true)
            ->first();

        if (!$perm) {
            return redirect('/?module=dashboard&page=home')->with('error', 'Access denied.');
        }

        return $next($request);
    }
}