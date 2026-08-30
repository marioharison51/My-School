<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Support\EnvWriter;
use App\Support\Installation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class InstallController extends Controller
{
    public function welcome(Request $request)
    {
        $detectedUrl = $request->getSchemeAndHttpHost();

        return view('install.welcome', [
            'detectedUrl' => $detectedUrl,
            'appName'     => session('install.app_name', config('app.name')),
        ]);
    }

    public function saveWelcome(Request $request)
    {
        $validated = $request->validate([
            'app_name' => ['required', 'string', 'max:100'],
            'app_url'  => ['required', 'url'],
        ]);

        session(['install' => array_merge(session('install', []), [
            'app_name' => $validated['app_name'],
            'app_url'  => rtrim($validated['app_url'], '/'),
        ])]);

        return redirect()->route('install.database');
    }

    public function database()
    {
        $hasExistingData = $this->databaseHasData();

        return view('install.database', compact('hasExistingData'));
    }

    public function saveDatabase(Request $request)
    {
        $validated = $request->validate([
            'choice' => ['required', 'in:keep,fresh'],
        ]);

        if ($validated['choice'] === 'fresh') {
            Artisan::call('migrate:fresh', ['--force' => true]);
        } else {
            Artisan::call('migrate', ['--force' => true]);
        }

        return redirect()->route('install.admin');
    }

    public function admin()
    {
        if (User::where('role', 'administrateur')->exists()) {
            return redirect()->route('install.finish');
        }

        return view('install.admin');
    }

    public function saveAdmin(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'administrateur',
        ]);

        return redirect()->route('install.finish');
    }

    public function finish()
    {
        $installData = session('install', []);

        if (! empty($installData['app_name'])) {
            EnvWriter::set('APP_NAME', $installData['app_name']);
        }

        if (! empty($installData['app_url'])) {
            EnvWriter::set('APP_URL', $installData['app_url']);
        }

        Artisan::call('config:clear');

        Installation::markInstalled();

        session()->forget('install');

        return view('install.finish');
    }

    private function databaseHasData(): bool
    {
        try {
            return Schema::hasTable('users') && User::query()->exists();
        } catch (\Throwable) {
            return false;
        }
    }
}
