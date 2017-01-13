<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    public function index()
    {

    }

    public function create(Request $request)
    {
        $file = $request->file('Filedata');

        if ($file->isValid()) {
            $clientName = $file->getClientOriginalName();

            $extension = $file->getClientOriginalExtension();

            $newName = md5(date('ymdhis') . $clientName) . "." . $extension; //生成文件名

            $path = $file->move('uploads/', $newName); //将图片移到服务器文件夹

            $path = addcslashes($path, '/');
            return $path;
        }
    }
}