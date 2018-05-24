<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use common\helpers\OfficeExcel;
use common\models\Expenses;
use backend\models\ExpensesSearch;

class ExportController extends Controller
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
        $data = $searchModel->export(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $data['dataProvider'],
            'summary' => $data['summary'],
        ]);
    }

    public function actionDownload()
    {
        $searchModel = new ExpensesSearch();
        $dataProvider = $searchModel->export(Yii::$app->request->queryParams)['dataProvider'];

        try {
            $filename = OfficeExcel::exportExpenses($dataProvider);
            return Yii::$app->response->sendFile($filename);
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('danger', $e->getMessage());
            return $this->redirect(['index']);
        }
    }
}
