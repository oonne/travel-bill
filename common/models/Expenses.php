<?php

namespace common\models;

class Expenses extends ActiveRecord
{
    const RECEIPT_NO = 0;
    const RECEIPT_YES = 1;

    private static $_receiptList;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%expenses}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            parent::timestampBehavior()
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['expenses_item', 'expenses_city', 'expenses_category', 'expenses_trip', 'expenses_money', 'expenses_date', 'expenses_handler', 'expenses_receipt'], 'required', 'on' => ['creation']],

            [['expenses_item'], 'string', 'max' => 32],
            [['expenses_city'], 'string', 'max' => 32],
            [['expenses_money'], 'number', 'min' => '0.00'],
            [['expenses_date'], 'date', 'format' => 'yyyy-mm-dd'],

            [
                ['expenses_category'],
                'exist',
                'targetClass' => Category::className(),
                'targetAttribute' => 'id'
            ],
            [
                ['expenses_trip'],
                'exist',
                'targetClass' => Trip::className(),
                'targetAttribute' => 'id'
            ],
            [
                ['expenses_handler'],
                'exist',
                'targetClass' => Handler::className(),
                'targetAttribute' => 'id'
            ],


            [['expenses_remark'], 'string', 'max' => 255],
            [['expenses_remark'], 'default','value' => ''],

            ['expenses_receipt', 'default', 'value' => self::RECEIPT_NO],
            ['expenses_receipt', 'in', 'range' => [self::RECEIPT_NO, self::RECEIPT_YES]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Expenses ID',
            'expenses_item' => '消费内容',
            'expenses_city' => '地点',
            'expenses_category' => '分类',
            'expenses_trip' => '出差项目',
            'expenses_money' => '金额',
            'expenses_date' => '日期',
            'expenses_handler' => '经手人',
            'expenses_remark' => '备注',
            'expenses_receipt' => '有无发票',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'last_editor' => '最后更新帐号',
            'dateRange' => '日期',
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'expenses_category']);
    }

    public function getTrip()
    {
        return $this->hasOne(Trip::className(), ['id' => 'expenses_trip']);
    }

    public function getHandler()
    {
        return $this->hasOne(Handler::className(), ['id' => 'expenses_handler']);
    }

    /**
     * Change receipt
     */
    public function receiptYes()
    {
        $this->expenses_receipt = self::RECEIPT_YES;
    }

    public function receiptNo()
    {
        $this->expenses_receipt = self::RECEIPT_NO;
    }

    /**
     * Get receipt
     */
    public static function getReceiptList()
    {
        if (self::$_receiptList === null) {
            self::$_receiptList = [
                self::RECEIPT_NO => '无',
                self::RECEIPT_YES => '有'
            ];
        }

        return self::$_receiptList;
    }

    public function getReceiptMsg()
    {
        $list = static::getReceiptList();

        return $list[$this->expenses_receipt] ?? null;
    }
}