<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActivateAssignmentRequest;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Http\Resources\GroupResource;
use App\Models\Assignment;
use App\Models\AssignmentGroup;
use App\Models\Group;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection|Response
     */
    public function index()
    {
        try {
            return GroupResource::collection(Group::paginate(10));
        }catch (\Exception $e){
            return response([
                'error' => $e->getMessage()
            ],400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreGroupRequest $request
     * @return Response
     */
    public function store(StoreGroupRequest $request): Response
    {
        try {
            $validated = $request->validated();

            Group::create($validated);

            return response([
                'success' => "Group is added successfully."
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
     * @param Group $group
     * @return GroupResource|Response
     */
    public function show(Group $group)
    {
        try {
            $group->load(['mentor', 'intern', 'assignment']);
            $group->assignment->where('pivot.is_active', true)->each(function ($query) {
                $query->makeVisible(['pivot']);
            });

            return new GroupResource($group);
        }catch (\Exception $e) {
            return response([
                'error' => $e->getMessage()
            ],400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateGroupRequest $request
     * @param Group $group
     * @return Response
     */
    public function update(UpdateGroupRequest $request, Group $group)
    {
        try {
            $validated = $request->validated();

            $group->update($validated);

            return response([
                'success' => 'Group updated successfully!',
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
     * @param Group $group
     * @return Response
     */
    public function destroy(Group $group)
    {
        try {
            $group->delete();

            return response([
                'success' => 'Group deleted successfully.'
            ],200);

        }catch (\Exception $e){
            return response([
                'error' => $e->getMessage()
            ],400);
        }
    }

    /**
     * Activate assignment.
     *
     * @param ActivateAssignmentRequest $request
     * @param Group $group
     * @param Assignment $assignment
     * @return Response
     */
    public function activateAssignment(ActivateAssignmentRequest $request, Group $group, Assignment $assignment)
    {
        if (in_array($assignment->id, $group->assignment->pluck('id')->toArray())){

            if (!$group->assignment->find($assignment->id)->pivot->is_active){

                $validated = $request->validated();

                $group->assignment()
                    ->updateExistingPivot($assignment->id, [
                        'start_date' => $validated['start_date'],
                        'end_date' => $validated['end_date'],
                        'is_active' => true,
                    ]);

                return response([
                    'success' => 'Assignment is activated',
                ],200);
            }
            return response([
                'error' => 'Assignment is already activated.',
            ],400);
        }else{
            return response([
                'error' => 'Group does not have that assignment!'
            ],400);
        }
    }

    /**
     * Deactivate assignment.
     *
     * @param Group $group
     * @param Assignment $assignment
     * @return Response
     */
    public function deactivateAssignment(Group $group, Assignment $assignment)
    {
        if (in_array($assignment->id, $group->assignment->pluck('id')->toArray())){

            if ($group->assignment->find($assignment->id)->pivot->is_active){

                $group->assignment()
                    ->updateExistingPivot($assignment->id, [
                        'start_date' => null,
                        'end_date' => null,
                        'is_active' => false,
                    ]);

                return response([
                    'success' => 'Assignment is deactivated',
                ],200);
            }
            return response([
                'error' => 'Assignment is already deactivated.',
            ],400);
        }else{
            return response([
                'error' => 'Group does not have that assignment!'
            ],400);
        }
    }

    /**
     * Add assignment to group.
     *
     * @param Group $group
     * @param Assignment $assignment
     * @return Response
     */
    public function addAssignment(Group $group, Assignment $assignment)
    {
        if (!in_array($assignment->id, $group->assignment->pluck('id')->toArray())){

            AssignmentGroup::create([
                'assignment_id' => $assignment->id,
                'group_id' => $group->id,
                'start_date' => null,
                'end_date' => null,
                'is_active' => false,
            ]);

            return response([
                'success' => 'Assignment is added',
            ],200);
        }else{
            return response([
                'error' => 'Group already have that assignment!'
            ],400);
        }
    }
}
