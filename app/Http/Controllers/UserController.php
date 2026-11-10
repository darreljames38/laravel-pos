<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Intervention\Image\Laravel\Facades\Image;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::orderBy('id')->get();

        return view('users.index', compact('users'));
    }

    public function create(): View
    {
        return view('users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'username' => [
                'required',
                'string',
                'max:50',
                'unique:users,username',
            ],
            'full_name' => [
                'required',
                'string',
                'max:100',
            ],
        ]);

        User::create($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user): View
    {
        return view('users.edit', compact('user'));
    }

    public function update(
        Request $request,
        User $user
    ): RedirectResponse {
        $validated = $request->validate([
            'username' => [
                'required',
                'string',
                'max:50',
                Rule::unique('users', 'username')->ignore($user->id),
            ],
            'full_name' => [
                'required',
                'string',
                'max:100',
            ],
            'avatar' => [
                'nullable',
                'image',
                'max:2048',
            ],
        ]);

        // Do not send the UploadedFile object to the database.
        unset($validated['avatar']);

        if ($request->hasFile('avatar')) {
            $uploadedFile = $request->file('avatar');

            $filename = Str::uuid() . '.jpg';
            $path = 'avatars/' . $filename;

            // Intervention Image v4
                   $imageData = file_get_contents(
                    $uploadedFile->getPathname()
                    );

                if ($imageData === false) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors([
                  'avatar' => 'The uploaded image could not be read.',
                ]);
                    }

                    $preparedImage = Image::decodeBinary($imageData)
                    ->cover(300, 300)
                    ->encodeUsingFileExtension(
                    'jpg',
                    quality: 85
                    );




            $stored = Storage::disk('public')->put(
                $path,
                $preparedImage
            );

            if (! $stored) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors([
                        'avatar' => 'The prepared avatar could not be stored.',
                    ]);
            }

            if (
                $user->avatar &&
                Storage::disk('public')->exists($user->avatar)
            ) {
                Storage::disk('public')->delete($user->avatar);
            }

            $validated['avatar'] = $path;
        }

        $user->update($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'User updated successfully.');
    }
}