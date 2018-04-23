<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\Review;
use App\Http\Resources\ReviewCollection;
use App\Http\Resources\ReviewResource;
use Illuminate\Http\Request;
use App\Model\Product;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\ReviewRequest;
use App\Exceptions\ReviewNotBelongsToProductException;
use App\Traits\ProductTrait;
use App\Traits\ReviewTrait;

class ReviewController extends Controller
{
    use ProductTrait;
    use ReviewTrait;

    public function __construct()
    {
        $this->middleware('auth:api')->except('index', 'show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        return ReviewCollection::collection($product->reviews);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\ReviewRequest  $request
     * @param  App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function store(ReviewRequest $request, Product $product)
    {
        $review = new Review($request->all());
        $product->reviews()->save($review);

        return response([
            'data' => new ReviewResource($review),
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product, Review $review)
    {
        return new ReviewResource($review);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product, Review $review)
    {
        $this->productUserCheck($product);
        $this->productReviewCheck($product, $review);
        $review->update($request->all());

        return response([
            'data' => new ReviewResource($review),
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Review $review)
    {
        $this->productUserCheck($product);
        $this->productReviewCheck($product, $review);
        $review->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
