<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Mail;

class TestController extends Controller
{
    public function index()
    {
        $arr = ['aa' => 'bb'];
        $res = cal_days_in_month(CAL_GREGORIAN, 2, 2017);

        dd($res);
    }

    //发送邮件
    public function sendEmail()
    {
        Mail::raw('这是一封测试邮件', function ($message) {
            $to = '2750006825@qq.com';
            $message->to($to)->subject('测试邮件');
        });
    }

    //导出excel
    public function export($rows)
    {
        $filename = Auth::user()->id . time();
        $excel = App::make('excel');
//        $rows = array(array('id' => 1, 'name' => 'marlon'));
        $excel->create($filename, function ($excel) use ($rows) {
            $excel->sheet('当天报名', function ($sheet) use ($rows) {
                $sheet->fromArray($rows);
            });
        })->download('xls');

    }

    //导入excel
    public function import($xFile)
    {
        $excel = App::make('excel');

        return $excel->load(($xFile), function ($reader) {
            //获取excel的第几张表
            $reader = $reader->getSheet(0);
            //获取表中的数据
            $result = $reader->toArray();
            //在这里的时候$results 已经是excel中的数据了,可以再这里对他进行操作,入库或者其他....
            return $result;
        });
        return $result;

    }
}
