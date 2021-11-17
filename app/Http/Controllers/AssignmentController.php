<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssignmentRequest;
use App\Http\Requests\UpdateAssignmentRequest;
use App\Http\Resources\AssignmentResource;
use App\Models\Assignment;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection|Response
     */
    public function index()
    {
        try {
            return AssignmentResource::collection(Assignment::paginate());
        }catch (\Exception $e){
            return response([
                'error' => $e->getMessage()
            ],400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAssignmentRequest $request
     * @return Response
     */
    public function store(StoreAssignmentRequest $request): Response
    {
        try {
            $validated = $request->validated();

            Assignment::create($validated);

            return response([
                'success' => "Assignment is added successfully."
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
     * @param Assignment $assignment
     * @return AssignmentResource|Response
     */
    public function show(Assignment $assignment)
    {
        try {
            return new AssignmentResource($assignment);
        }catch (\Exception $e){
            return response([
                'error' => $e->getMessage()
            ],400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAssignmentRequest $request
     * @param Assignment $assignment
     * @return Response
     */
    public function update(UpdateAssignmentRequest $request, Assignment $assignment): Response
    {
        try {
            $validated = $request->validated();

            $assignment->update($validated);

            return response([
                'success' => 'Assignment updated successfully!',
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
     * @param Assignment $assignment
     * @return Response
     */
    public function destroy(Assignment $assignment): Response
    {
        try {
            $assignment->delete();

            return response([
                'success' => 'Assignment deleted successfully.'
            ],200);

        }catch (\Exception $e){
            return response([
                'error' => $e->getMessage()
            ],400);
        }
    }
}
