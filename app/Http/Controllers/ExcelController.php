<?php


namespace App\Http\Controllers;



use Illuminate\Http\Request;
use Excel;
use App\Imports\ExcelImport;
use Input;
class ExcelController extends Controller
{
    public function index()
    {
        return view('admin.excel.index');
    }
    public function excelInit(Request $request,ExcelImport $excelImport)
    {
        $excelFile = $request->file('excel');

        if(!$excelFile->isValid()){
            return [
                'errcode' => 1,
                'errmsg' => '文件为非法文件，请检查传入文件'
            ];
        }

//        $this->excelStore($request,$excelImport);//录入数据

        $arr = $excelImport->toArray($excelFile);

        foreach ($arr as $key => &$value){
            foreach ($value as $k => &$v){
                if($this->checkData($v)) {
                    $transform = intval(($v['到期日期'] - 25569) * 3600 * 24);
                    //转换成1970年以来的秒数
                    $v['到期日期'] = gmdate('Y-m-d', $transform);
                }else{
                    unset($arr[$key][$k]);
                }
            }
        }
        return [
            'errcode' => 0,
            'arr' => $arr
        ];
    }

    public function excelStore(Request $request,ExcelImport $excelImport)
    {
        $excelImport->import($request->file('excel'));

        return back()->with('success', '导入成功');
    }

    public function checkData($arr)
    {
        if($arr['姓名'] == '姓名'||$arr['手机号'] == '手机号'){
            return false;
        }
        if(!empty($arr['姓名']) && empty($arr['手机号'])){
            return false;
        }
        if(empty($arr['姓名']) && empty($arr['手机号'])){
            return false;
        }
        return true;
    }
}