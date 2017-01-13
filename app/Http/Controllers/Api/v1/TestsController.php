<?php
namespace App\Http\Controllers\Api\v1;


use App\Client;
use App\Http\Controllers\Api\Transformers\TestsTransformer;

class TestsController extends BaseController
{
    public function index()
    {
        $tests = Client::all();
        return $this->collection($tests, new TestsTransformer());
    }

    public function show($id)
    {
        $test = Client::find($id);
        if (!$test) {
            return $this->response->errorNotFound('Test not found');
        }
        return $this->item($test, new TestsTransformer());
    }
}