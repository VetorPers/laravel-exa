<?php

namespace App\Http\Controllers\Api\Transformers;

/**该类为dingo api封装好**/
use League\Fractal\TransformerAbstract;

class TestsTransformer extends TransformerAbstract
{
    /***
     * 分开为了解耦
     * 数据字段选择
     * @param $lesson
     * @return array
     */
    public function transform($lesson)
    {
        /******隐藏数据库字段*****/
        return [
            'name' => $lesson['name'],
            'account' => $lesson['account'],
        ];
    }
}