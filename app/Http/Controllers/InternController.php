<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInternRequest;
use App\Http\Requests\UpdateInternRequest;
use App\Http\Resources\InternResource;
use App\Models\Group;
use App\Models\Intern;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class InternController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection|Response
     */
    public function index()
    {
        try {
            return InternResource::collection(Intern::with('group')->paginate(10));
        }catch (\Exception $e){
            return response([
                'error' => $e->getMessage()
            ],400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreInternRequest $request
     * @return Response
     */
    public function store(StoreInternRequest $request): Response
    {
        try {
            $validated = $request->validated();

            Intern::create($validated);

            return response([
                'success' => "Intern is added successfully."
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
     * @param Intern $intern
     * @return InternResource|Response
     */
    public function show(Intern $intern)
    {
        try {
            $intern->load(['group.assignment']);
            $intern->group->assignment->makeHidden('pivot');

            return new InternResource($intern);
        }catch (\Exception $e) {
            return response([
                'error' => $e->getMessage()
            ],400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateInternRequest $request
     * @param Intern $intern
     * @return Response
     */
    public function update(UpdateInternRequest $request, Intern $intern): Response
    {
        try {
            if ($request->group_id != null) {
                $group = Group::all()->pluck('id')->toArray();

                if (!in_array($request->group_id, $group)) {
                    return response([
                        'error' => 'That group does not exists!'
                    ], 400);
                }
                $intern->update($request->all());

                return response([
                    'success' => 'Intern updated successfully!',
                ],200);
            }
            $intern->update($request->all());

            return response([
                'success' => 'Intern updated successfully!',
            ],200);
        }catch (\Exception $e){
            return response([
                'error' => $e->getMessage(),
            ],400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Intern $intern
     * @return Response
     */
    public function destroy(Intern $intern): Response
    {
        try {
            $intern->delete();

            return response([
                'success' => 'Intern deleted successfully.'
            ],200);

        }catch (\Exception $e){
            return response([
                'error' => $e->getMessage()
            ],400);
        }
    }
}
