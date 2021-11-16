<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssignmentRequest;
use App\Http\Requests\UpdateAssignmentRequest;
use App\Http\Resources\AssignmentResource;
use App\Models\Assignment;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return AssignmentResource::collection(Assignment::paginate());
        }catch (\Exception $e){
            return response([
                'error' => $e->getMessage()
            ],403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAssignmentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAssignmentRequest $request)
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
     * @return AssignmentResource|\Illuminate\Http\Response
     */
    public function show(Assignment $assignment)
    {
        try {
            return new AssignmentResource($assignment);
        }catch (\Exception $e){
            return response([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAssignmentRequest $request
     * @param Assignment $assignment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAssignmentRequest $request, Assignment $assignment)
    {
        try {
            $assignment->update($request->all());

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
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assignment $assignment)
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
