<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return UserResource::collection(User::paginate(10));
        }catch (\Exception $e){
            return response([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $validated = $request->validated();

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'city' => $validated['city'],
                'skype' => $validated['skype'],
                'group_id' => $validated['group_id']
                ]);

            $user->assignRole('mentor');

            return response([
                'success' => "User is added successfully."
            ],200);
        }catch (\Exception $e){
            return response([
                'error' => $e->getMessage()
            ],400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return UserResource|\Illuminate\Http\Response
     */
    public function show(User $user)
    {
        try {
            $mentor = User::with(['group','group.intern'])->find($user->id);

            return new UserResource($mentor);
        }catch (\Exception $e){
            return response([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            if(Auth::user()->id == $user['id']) {
                $user->update($request->all());

                return response([
                    'success' => 'User updated successfully!',
                ], 200);
            }else{
                return response([
                    'error' => 'Unauthorized'
                ],401);
            }
        }catch (\Exception $e){
            return response([
                'error' => $e->getMessage(),
            ],400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();

            return response([
                'success' => 'Mentor deleted successfully.'
            ],200);

        }catch (\Exception $e){
            return response([
                'error' => $e->getMessage()
            ],400);
        }
    }

    /**
     * Change role of specific user.
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function changeRole(User $user, Request $request)
    {
        try {
            $this->validate($request, [
                'role' => 'required'
            ]);
            $input = $request->all();

            $user->syncRoles($request->input('role'));

            return response([
                'success' => 'Role successfully changed.',
            ],200);

        }catch (\Exception $e){
            return response([
                'error' => $e->getMessage(),
            ],400);
        }
    }
}
