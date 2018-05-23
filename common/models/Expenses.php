<?php

namespace common\models;

class Expenses extends ActiveRecord
{
    const RECEIPT_YES = 0;
    const RECEIPT_NO = 1;

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
            [['expenses_item', 'expenses_category', 'expenses_money', 'expenses_date', 'expenses_handler'], 'required', 'on' => ['creation']],

            [['expenses_item'], 'string', 'max' => 32],
            [['expenses_money'], 'number', 'min' => '0.00'],
            [['expenses_date'], 'date', 'format' => 'yyyy-mm-dd'],

            [
                ['expenses_category'],
                'exist',
                'targetClass' => Category::className(),
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
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Expenses ID',
            'expenses_item' => '项目',
            'expenses_city' => '地点',
            'expenses_category' => '分类',
            'expenses_trip' => '项目',
            'expenses_money' => '金额',
            'expenses_date' => '日期',
            'expenses_handler' => '经手人',
            'expenses_remark' => '备注',
            'expenses_receipt' => '发票',
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

    public function getHandler()
    {
        return $this->hasOne(Handler::className(), ['id' => 'expenses_handler']);
    }
}