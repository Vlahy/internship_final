<?php

namespace App\Http\Controllers;

use App\Http\Resources\InternResource;
use App\Models\Intern;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InternController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $interns = InternResource::collection(Intern::all());

        return $interns;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Intern  $intern
     * @return \Illuminate\Http\Response
     */
    public function show(Intern $intern)
    {
        $interns = new InternResource($intern);

        return $interns;
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
        //
    }
}
