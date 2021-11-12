<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInternRequest;
use App\Http\Resources\InternResource;
use App\Models\Intern;
use Illuminate\Http\Request;

class InternController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return InternResource::collection(Intern::with('group')->paginate(10));
        }catch (\Exception $e){
            return response([
                'error' => $e->getMessage()
            ],403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreInternRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInternRequest $request)
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
     * @param  \App\Models\Intern  $intern
     * @return InternResource|\Illuminate\Http\Response
     */
    public function show(Intern $intern)
    {
        try {
            $interns = Intern::with(['group','group.assignment'])->find($intern->id);

            return new InternResource($interns);
        }catch (\Exception $e) {
            return response([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Intern  $intern
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Intern $intern)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Intern  $intern
     * @return \Illuminate\Http\Response
     */
    public function destroy(Intern $intern)
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
