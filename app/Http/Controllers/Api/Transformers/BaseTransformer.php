<?php

namespace App\Http\Controllers\Api\Transformers;

use Illuminate\Database\Eloquent\Model;
use League\Fractal\TransformerAbstract;

class BaseTransformer extends TransformerAbstract
{
    public function transform(Model $object)
    {
        return $object->attributesToArray();
    }
}
