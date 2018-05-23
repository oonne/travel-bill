<?php

namespace common\models;

use Yii;
use oonne\sortablegrid\SortableGridBehavior;
use yii\db\Query;

class Trip extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%trip}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            parent::timestampBehavior(),
            [
                'class' => SortableGridBehavior::className(),
                'sortableAttribute' => 'trip_sequence'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['trip_name'], 'required', 'on' => ['creation']],
            [['trip_name'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Trip ID',
            'trip_name' => '项目名',
            'trip_sequence' => '分类排序',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
            'last_editor' => '最后修改人ID',
        ];
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public static function getKeyValuePairs()
    {
        $query = (new Query())->select(['id', 'trip_name'])
            ->from([self::tableName()])
            ->orderBy(['trip_sequence' => SORT_DESC]);

        list($sql, $params) = Yii::$app->db->getQueryBuilder()->build($query);
        $data = Yii::$app->db->createCommand($sql)->queryAll(\PDO::FETCH_KEY_PAIR);
        return $data;
    }

    public static function getTripList()
    {
        $query = (new Query())->select(['id', 'trip_name'])
            ->from([self::tableName()])
            ->orderBy(['trip_sequence' => SORT_DESC]);

        list($sql, $params) = Yii::$app->db->getQueryBuilder()->build($query);
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        return $data;
    }
}