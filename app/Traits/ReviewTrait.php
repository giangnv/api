<?php

namespace App\Traits;

use App\Model\Product;
use App\Model\Review;
use App\Exceptions\ReviewNotBelongsToProductException;

trait ReviewTrait
{

    protected function ProductReviewCheck(Product $product, Review $review)
    {
        if ($product->reviews()->find($review)->isEmpty()) {
            throw new ReviewNotBelongsToProductException;
        }
    }
}