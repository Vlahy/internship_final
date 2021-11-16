<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Intern;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index($intern)
    {
        try {
            return ReviewResource::collection(Review::where('intern_id', $intern)->paginate(10));
        }catch (\Exception $e){
            return response([
                'error' => $e->getMessage()
            ],400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreReviewRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReviewRequest $request)
    {
        try {

            $validated = $request->validated();
            $user = Auth::user();

                $intern = Intern::where('id', $validated['intern_id'])->first();

                if ($user->group_id == $intern->group_id){

                    $internAssignment = $intern->group->assignment->pluck('id')->toArray();

                    if(in_array($validated['assignment_id'], $internAssignment)){

                        Review::create([
                            'pros' => $validated['pros'],
                            'cons' => $validated['cons'],
                            'mark' => $validated['mark'],
                            'assignment_id' => $validated['assignment_id'],
                            'mentor_id' => $user->id,
                            'intern_id' => $validated['intern_id'],
                        ]);

                        return response([
                            'success' => "Review is added successfully."
                        ],200);
                    }else{
                        return response([
                            'error' => 'Intern does not have that assignment!'
                        ],200);
                    }

                }else{
                    return response([
                        'error' => 'Mentor is not in the same group as intern!'
                    ],400);
                }

        }catch (\Exception $e){
            return response([
                'error' => $e->getMessage()
            ],400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Review $review
     * @return ReviewResource|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function show($intern ,$assignment)
    {
        try {
            $reviews = Review::where('assignment_id', $assignment)
            ->where('intern_id', $intern)
            ->get();

            return new ReviewResource($reviews);
        }catch (\Exception $e){
            return response([
                'error' => $e->getMessage()
            ],400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateReviewRequest $request
     * @param Review $review
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReviewRequest $request, Review $review)
    {
        try {
            $user = Auth::user();
            if ($user->id == $review->mentor_id) {

                $review->update($request->all());
                return response([
                    'success' => 'Review updated successfully!',
                ], 200);
            }else{
                return response([
                    'error' => 'Only mentor that did review can edit this review.'
                ]);
            }
        }catch(\Exception $e){
            return response([
                'error' => $e->getMessage(),
            ],400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Review $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        try {
            $review->delete();

            return response([
                'success' => 'Review deleted successfully.'
            ],200);

        }catch (\Exception $e){
            return response([
                'error' => $e->getMessage()
            ],400);
        }
    }
}
