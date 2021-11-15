<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActivateAssignmentRequest;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Http\Resources\GroupResource;
use App\Models\Assignment;
use App\Models\AssignmentGroup;
use App\Models\Group;
use Illuminate\Http\Request;
use Nette\Utils\DateTime;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return GroupResource::collection(Group::paginate(10));
        }catch (\Exception $e){
            return response([
                'error' => $e->getMessage()
            ],403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreGroupRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGroupRequest $request)
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
     * @return GroupResource|\Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        try {
            $groups = Group::with(['mentor','intern','assignment' => function ($query) {
                $query->where('is_active', true);
            }])
                ->find($group->id);

            return new GroupResource($groups);
        }catch (\Exception $e) {
            return response([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateGroupRequest $request
     * @param Group $group
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGroupRequest $request, Group $group)
    {
        try {
            $group->update($request->all());

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
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
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
            ]);
        }
    }

    /**
     * Deactivate assignment.
     *
     * @param Group $group
     * @param Assignment $assignment
     * @return \Illuminate\Http\Response
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
            ]);
        }
    }

    /**
     * Add assignment to group.
     *
     * @param Group $group
     * @param Assignment $assignment
     * @return \Illuminate\Http\Response
     */
    public function addAssignment(Group $group, Assignment $assignment)
    {
        if (!in_array($assignment->id, $group->assignment->pluck('id')->toArray())){

            // todo add logic for connecting assignment and group

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
