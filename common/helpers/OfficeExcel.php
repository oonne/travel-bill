<?php

namespace common\helpers;

use Yii;
use yii\data\BaseDataProvider;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class OfficeExcel
{
    /**
     * 导出账单
     *
     * @param BaseDataProvider $dataProvider
     * @return string the filename of excel
     */
    public static function exportExpenses(BaseDataProvider $dataProvider)
    {
        // 生成表格
        $tempate = Yii::$app->params['excel.templatyFilename'];
        $spreadsheet = IOFactory::load($tempate);

        // TODO

        // 写入文件
        $filename = '测试excel' . date("_Ymd_His") . '.xlsx';
        // $filename = '出差报销单' . date("_Ymd_His") . '.xlsx';
        $filename = Yii::getAlias(Yii::$app->params['excel.exportPath']) . DIRECTORY_SEPARATOR . $filename;
        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        return $filename;
    }
}