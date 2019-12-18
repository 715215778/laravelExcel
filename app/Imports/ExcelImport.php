<?php

namespace App\Imports;

use App\Models\Excel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsFailures;
class ExcelImport implements ToModel, WithHeadingRow, WithMultipleSheets, WithChunkReading, WithBatchInserts, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $transform = intval(($row['到期日期'] - 25569) * 3600 * 24);
        //转换成1970年以来的秒数
        $row['到期日期'] = gmdate('Y-m-d', $transform);

        $excel = new Excel([
            'name' => $row['姓名'],
            'group' => $row['组别'],
            'sex' => $row['性别'],
            'phone' => $row['手机号'],
            'email' => $row['个人邮箱'],
            'dept' => $row['部门'],
            'leader' => $row['责任人'],
            'date' => $row['到期日期'],
            'desc' => $row['备注'],
        ]);


        return $excel;
    }

    //验证规则
    public function rules(): array
    {
        return [
            '姓名' => function ($attribute, $value, $onFailure) {
                if ($value == '姓名' || $value == null) {
                    $onFailure('name is ERROR');
                }
            },
            '到期日期' => function ($attribute, $value, $onFailure) {
                if ($value == null) {
                    $onFailure('date is ERROR');
                }
            },
            '手机号' => function ($attribute, $value, $onFailure) {
                if ($value == null) {
                    $onFailure('phone is ERROR');
                }
            }
        ];
    }


    public function onFailure(Failure ...$failures)
    {
        // Handle the failures how you'd like.
    }

    //引入哪张表
    public function sheets(): array
    {
        return [
            0 => new self(),
//            'Sheet1' => new self(),//指定表名
        ];
    }

    //一次处理多少条
    public function batchSize(): int
    {
        return 100;
    }

    //分块读取
    public function chunkSize(): int
    {
        return 1000;
    }

    //第二行作为标题行
    public function headingRow(): int
    {
        return 2;
    }
}
