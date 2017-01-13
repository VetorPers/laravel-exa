<?php

namespace App\Http\Controllers\Api\Transformers;

use App\Member;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(Member $user)
    {
        return $user->attributesToArray();
    }
}
