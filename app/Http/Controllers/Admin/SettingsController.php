<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $dbSettings = Setting::pluck('value', 'key')->toArray();
        $defaultSettings = [
            'site_name' => 'eyetails.co',
            'site_description' => 'Mendefinisikan kembali gaya urban dengan desain minimalis yang fungsional dan tahan lama.',
            'default_email' => 'support@eyetails.co',
            'default_phone' => '+62 812 XXXX XXXX',
            'address' => 'Jl. xxxx No. 123, Jakarta Pusat',
            'logo_path' => null,
            'favicon_path' => null,
        ];
        $settings = array_merge($defaultSettings, $dbSettings);
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'required|string|max:500',
            'default_email' => 'required|email',
            'default_phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            // Validasi untuk logo_file dihapus
            'favicon_file' => 'nullable|image|mimes:ico,png|max:1024',
        ]);

        $data = $request->only(['site_name', 'site_description', 'default_email', 'default_phone', 'address']);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value ?? '']);
        }

        // Blok logika untuk upload logo_file dihapus

        if ($request->hasFile('favicon_file')) {
            $path = $request->file('favicon_file')->store('settings', 'public');
            $oldFavicon = Setting::where('key', 'favicon_path')->first();
            if ($oldFavicon && $oldFavicon->value && Storage::disk('public')->exists($oldFavicon->value)) {
                Storage::disk('public')->delete($oldFavicon->value);
            }
            Setting::updateOrCreate(['key' => 'favicon_path'], ['value' => $path]);
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan website berhasil diperbarui.');
    }

    public function remove($key)
    {
        // Validasi hanya mengizinkan favicon_path
        if ($key !== 'favicon_path') {
            return redirect()->route('admin.settings.index')->withErrors('Tindakan tidak valid.');
        }

        $setting = Setting::where('key', $key)->first();

        if ($setting) {
            if ($setting->value && Storage::disk('public')->exists($setting->value)) {
                Storage::disk('public')->delete($setting->value);
            }
            $setting->delete();
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Favicon berhasil dihapus.');
    }
}
