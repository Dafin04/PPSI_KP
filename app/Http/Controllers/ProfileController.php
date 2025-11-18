<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Mahasiswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Arr;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $user = $request->user();

        $user->fill(Arr::only($validated, ['name', 'email']));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $mahasiswaPayload = Arr::only($validated, [
            'nim',
            'angkatan',
            'ipk',
            'prestasi_akademik',
            'prestasi_non_akademik',
            'pengalaman_si',
        ]);

        $hasPayload = collect($mahasiswaPayload)->filter(fn ($value) => $value !== null && $value !== '')->isNotEmpty();

        if ($hasPayload) {
            $mahasiswa = $user->mahasiswa;
            if (!$mahasiswa) {
                $mahasiswa = new Mahasiswa([
                    'user_id' => $user->id,
                ]);
            }

            $mahasiswa->fill($mahasiswaPayload);
            $mahasiswa->save();
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
