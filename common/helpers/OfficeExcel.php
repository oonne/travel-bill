<?php

namespace common\helpers;

use Yii;
use yii\data\BaseDataProvider;
use common\models\Expenses;
use backend\models\ExpensesSearch;

class OfficeExcel
{
    /**
     * 导出账单
     *
     * @param BaseDataProvider $dataProvider
     * @return string the filename of excel
     */
    public static function exportCouponAuditCsv(BaseDataProvider $dataProvider)
    {
        // $filename = 'couponAudit' . date("_Ymd_His") . '.csv';
        // $filepath = Yii::getAlias(Yii::$app->params['excel.exportPath']) . DIRECTORY_SEPARATOR . $filename;

        // $content = '';
        // $content .= '申请编号,申请人,申请类型,申请状态,申请说明,用户列表,每用户数量(张),优惠券名称,优惠券类型,优惠类型,可用起始日期,可用结束日期,省(可用范围),市(可用范围),县/区(可用范围),街区(可用范围),订单最低金额(元),最大优惠金额(元),优惠金额/折扣率,一句话描述,申请时间';

        // foreach ($dataProvider->getModels() as $model) {
        //     $rowArray = [
        //         '`' . $model->uApplyNo,
        //         $model->sponsor->sNickname,
        //         $model->distributionTypeMsg,
        //         $model->statusMsg,
        //         str_replace(',' , '，', $model->sRemark),
        //         str_replace(',' , ';', $model->sMobiles),
        //         $model->uNumber,
        //         $model->sName,
        //         $model->couponTypeMsg,
        //         $model->promotionTypeMsg,
        //         $model->sCouponDateFrom,
        //         $model->sCouponDateTo,
        //         $model->province,
        //         $model->city,
        //         $model->district,
        //         $model->block,
        //         $model->dCanUseMoney,
        //         $model->dMaxDiscountMoney,
        //         $model->dDiscount,
        //         str_replace(',' , '，', $model->sDescription),
        //         $model->sCreatedTime,
        //     ];

        //     $content .= "\r\n" . implode(',', $rowArray);
        // }

        // file_put_contents($filepath, iconv('utf-8', 'GBK//IGNORE', $content));
        // return $filepath;
    }
}