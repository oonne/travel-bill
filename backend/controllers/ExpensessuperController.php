<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use common\models\Expenses;
use backend\models\ExpensesSearch;
use common\models\Recycle;

class ExpensessuperController extends Controller
{
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    public function actionIndex()
    {
        $searchModel = new ExpensesSearch();
        $data = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $data['dataProvider'],
            'summary' => $data['summary'],
        ]);
    }

    public function actionAddExpenses()
    {
        $model = new Expenses();
        $model->setScenario('creation');

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->last_editor = Yii::$app->user->id;
                if ($model->save(false)) {
                    Yii::$app->session->setFlash('success', '添加成功！');
                    return $this->redirect(['index']);
                } else {
                    Yii::$app->session->setFlash('danger', '添加失败。');
                }
            }
        }

        return $this->render('form', [
            'model' => $model
        ]);
    }

    public function actionUpdateExpenses($id)
    {
        $model = Expenses::findOne($id);

        if (!$model) {
            Yii::$app->session->setFlash('danger', '查无记录');
            return $this->redirect(['index']);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->last_editor = Yii::$app->user->id;
                if ($model->save(false)) {
                    Yii::$app->session->setFlash('success', '更新成功！');
                    return $this->redirect(['index']);
                } else {
                    Yii::$app->session->setFlash('danger', '更新失败。');
                }
            }
        }

        return $this->render('form', [
            'model' => $model,
        ]);
    }

    public function actionViewExpenses($id)
    {
        $model = Expenses::findOne($id);

        if (!$model) {
            Yii::$app->session->setFlash('danger', '查无记录');
            return $this->redirect(['index']);
        }

        return $this->render('view', [
            'model' => $model
        ]);
    }

    public function actionDeleteExpenses($id)
    {
        $model = Expenses::findOne($id);

        if (!$model) {
            Yii::$app->session->setFlash('danger', '查无记录');
            return $this->redirect(['index']);
        }

        $transaction = Yii::$app->db->beginTransaction();
        $recycleContent = '<p>项目：'. ($model->trip ? $model->trip->trip_name : '出差项目错误' ).'</p>';
        $recycleContent = $recycleContent .'<p>地点：'. $model->expenses_city .'</p>';
        $recycleContent = $recycleContent .'<p>内容：'. $model->expenses_item .'</p>';
        $recycleContent = $recycleContent .'<p>分类：'. ($model->category ? $model->category->category_name : '分类错误' ).'</p>';
        $recycleContent = $recycleContent .'<p>金额：'. $model->expenses_money .'</p>';
        $recycleContent = $recycleContent .'<p>时间：'. $model->expenses_date .'</p>';
        $recycleContent = $recycleContent .'<p>经手人：'. ($model->handler ? $model->handler->handler_name : '经手人错误' ) .'</p>';
        $recycleContent = $recycleContent .'<p>有无发票：'. $model->receiptMsg .'</p>';
        $recycleContent = $recycleContent .'<p>备注：'. $model->expenses_remark .'</p>';
        $recycle = new Recycle();
        $recycle->recycle_type = Recycle::TYPE_EXPENSES;
        $recycle->recycle_content = $recycleContent;
        if($recycle->validate()&&$recycle->save(false)){
            try {
                if (!$model->delete()) {
                    throw new \Exception('删除失败！');
                }

                $transaction->commit();
                Yii::$app->session->setFlash('success', '删除成功！');
                return $this->redirect(['index']);
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('danger', $e->getMessage());
            }
        }else{
            $transaction->rollBack();
            Yii::$app->session->setFlash('danger', '回收失败');
        }

        return $this->redirect(['index']);
    }
}
