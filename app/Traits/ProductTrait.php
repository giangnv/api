<?php

namespace App\Traits;

use App\Model\Product;
use Auth;
use App\Exceptions\ProductNotBelongsToUserException;

trait ProductTrait
{

    /**
     * Check product is belong to user.
     *
     * @param  \App\Model\Product  $product
     * @throw ProductNotBelongsToUserException
     */
    protected function productUserCheck($product)
    {
        if (Auth::id() !== $product->user_id) {
            throw new ProductNotBelongsToUserException;
        }
    }
}
