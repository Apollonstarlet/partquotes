<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class InfoUserController extends Controller {
	public function create() {
		return view('pages.user-management.create');
	}

	public function index() {
		return view('pages.user-management.index')->with('users', User::all());
	}

	public function edit($id) {
		return view('pages.user-management.edit')->with('user', User::find($id));
	}

	public function store(Request $request): RedirectResponse {
		$attributes = request()?->validate([
			'name' => ['required', 'max:255'],
			'email' => ['required', 'email', 'max:50', Rule::unique('users')->ignore(Auth::user()->id)],
			'password' => ['required', 'min:8', 'max:64'],
		]);

		$user = new User();
		$user->name = $attributes['name'];
		$user->email = $attributes['email'];
		$user->password = bcrypt($attributes['password']);

		$user->save();
		session()->flash('success', 'A new user was successfully created.');

		return redirect()->route('user-management.index');
	}

	public function update(Request $request, $id): RedirectResponse {
		$user = User::findOrFail($id);

		$attributes = $request->validate([
			'name' => ['required', 'max:255'],
			'email' => ['required', 'email', 'max:50', Rule::unique('users')->ignore($user->id)],
			'password' => ['required', 'min:8', 'max:64'],
		]);

		$user->name = $attributes['name'];
		$user->email = $attributes['email'];
		$user->password = bcrypt($attributes['password']);

		$user->save();
		session()->flash('success', 'User details have been updated successfully.');

		return redirect()->route('user-management.index');
	}

	public function destroy(Request $request, $id) {
		// Find the user by ID
		$user = User::find($id);

		if ($user) {
			if ($user->isAdmin()) {
				$request->session()->flash('error', 'This user cannot be deleted');

				return redirect()->route('users.index');
			}

			$user->delete();

			// Set a success message in the session
			$request->session()->flash('success', 'The user was successfully deleted.');
		} else {
			$request->session()->flash('error', 'User not found!');
		}

		return redirect()->route('user-management.index');
	}
}
