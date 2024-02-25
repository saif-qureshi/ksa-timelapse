<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Http\Requests\UserRequest;
use App\Models\Developer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function create()
    {
        $developers = Developer::selectRaw('id as value, name as label')->where('is_active', true)->get();

        $roles = collect(Roles::toArray())->map(fn ($item) => [
            'label' => Str::of($item)->replace('_', ' ')->ucfirst()->value,
            'value' => $item
        ]);

        return view('user.create', compact('developers', 'roles'));
    }

    public function store(UserRequest $request)
    {
        $inputs = $request->validated();

        $user = User::create($inputs);

        $user->developers()->sync($inputs['developers']);
        $user->projects()->sync($inputs['projects']);

        return response()->json('User created successfully', Response::HTTP_CREATED);
    }

    public function show(User $user)
    {
        //
    }

    public function edit(User $user)
    {

        $user->load(['projects', 'developers']);

        $user->developers = $user->developers->pluck('id')->toArray();
        $user->projects = $user->projects->pluck('id')->toArray();

        $user->unsetRelations(['projects', 'developers']);

        $developers = Developer::selectRaw('id as value, name as label')->where('is_active', true)->get();

        $roles = collect(Roles::toArray())->map(fn ($item) => [
            'label' => Str::of($item)->replace('_', ' ')->ucfirst()->value,
            'value' => $item
        ]);

        return view('user.edit', compact('developers', 'roles', 'user'));
    }

    public function update(UserRequest $request, User $user)
    {
        $inputs = $request->validated();

        $user->update($inputs);

        $user->developers()->sync($inputs['developers']);
        $user->projects()->sync($inputs['projects']);

        return response()->json('User updated successfully', Response::HTTP_ACCEPTED);
    }

    public function destroy(User $user)
    {
        //
    }
}
