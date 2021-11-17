<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeRoleRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection|Response
     */
    public function index()
    {
        try {
            return UserResource::collection(User::role('mentor')->paginate(10));
        }catch (\Exception $e){
            return response([
                'error' => $e->getMessage()
            ],400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return Response
     */
    public function store(StoreUserRequest $request): Response
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
     * @return UserResource|Response
     */
    public function show(User $user)
    {
        try {
            $user->load(['group', 'group.intern']);

            return new UserResource($user);
        }catch (\Exception $e){
            return response([
                'error' => $e->getMessage()
            ],400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return Response
     */
    public function update(UpdateUserRequest $request, User $user): Response
    {
        try {
            if(Auth::user()->id == $user['id'] || Auth::user()->role('admin')) {
                $validated = $request->validated();

                $user->update($validated);

                return response([
                    'success' => 'User updated successfully!',
                ], 200);
            }else{
                return response([
                    'error' => 'Unauthorized'
                ],403);
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
     * @return Response
     */
    public function destroy(User $user): Response
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
     * @param User $user
     * @param ChangeRoleRequest $request
     * @return Response
     */
    public function changeRole(User $user, ChangeRoleRequest $request): Response
    {
        try {
            $validated = $request->validated();

            $user->syncRoles($validated);

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
