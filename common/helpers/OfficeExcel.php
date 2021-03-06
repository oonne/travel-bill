<?php

namespace common\helpers;

use Yii;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class OfficeExcel
{
    /**
     * 导出账单
     *
     * @param $data
     * @return string the filename of excel
     */
    public static function exportExpenses($data)
    {
        // 导入表格模版
        $tempate = Yii::$app->params['excel.templatyFilename'];
        $spreadsheet = IOFactory::load($tempate);
        $sheet = $spreadsheet->getActiveSheet();

        // 写入数据
        $serialNumber = 2;
        foreach ($data['dataProvider']->getModels() as $model) {
            $sheet->setCellValue('A' . $serialNumber, $model->trip->trip_name);
            $sheet->setCellValue('B' . $serialNumber, $model->expenses_date);
            $sheet->setCellValue('C' . $serialNumber, $model->category->category_name);
            $sheet->setCellValue('D' . $serialNumber, $model->expenses_money);
            $sheet->setCellValue('E' . $serialNumber, $model->handler->handler_name);
            $sheet->setCellValue('F' . $serialNumber, $model->receiptMsg);
            $sheet->setCellValue('G' . $serialNumber, $model->expenses_remark);
            
            $serialNumber++;
        }
        $sheet->setCellValue('C' . $serialNumber, '合计');
        $sheet->setCellValue('D' . $serialNumber, $data['summary']);

        // 写入文件
        $filename = '出差报销单' . date("_Ymd_His") . '.xlsx';
        $filename = Yii::getAlias(Yii::$app->params['excel.exportPath']) . DIRECTORY_SEPARATOR . $filename;
        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        return $filename;
    }
}