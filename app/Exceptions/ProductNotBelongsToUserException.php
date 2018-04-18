<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation;

class ProductNotBelongsToUserException extends Exception
{
    
    public function render()
    {
        return response()->json([
            'This product not belongs to user'
        ]);
    }
}
