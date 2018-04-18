<?php

namespace App\Exceptions;

use Exception;

class ReviewNotBelongsToProductException extends Exception
{
    public function render()
    {
        return [
            'errors' => 'This review is not belongs to product',
        ];
    }
}
