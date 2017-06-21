<?php

namespace dungang\activity\workflow\controllers;

use Yii;
use dungang\activity\workflow\models\Arc;
use dungang\activity\workflow\models\ArcSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ArcController implements the CRUD actions for Arc model.
 */
class ArcController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Arc models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $searchModel = new ArcSearch(['workflowId'=>$id]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'workflowId'=>$id,
        ]);
    }

    /**
     * Displays a single Arc model.
     * @param integer $workflowId
     * @param integer $placeId
     * @param integer $transitionId
     * @return mixed
     */
    public function actionView($workflowId, $placeId, $transitionId)
    {
        return $this->render('view', [
            'model' => $this->findModel($workflowId, $placeId, $transitionId),
        ]);
    }

    /**
     * Creates a new Arc model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($workflowId)
    {
        $model = new Arc(['workflowId'=>$workflowId]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'workflowId' => $model->workflowId, 'placeId' => $model->placeId, 'transitionId' => $model->transitionId]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Arc model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $workflowId
     * @param integer $placeId
     * @param integer $transitionId
     * @return mixed
     */
    public function actionUpdate($workflowId, $placeId, $transitionId)
    {
        $model = $this->findModel($workflowId, $placeId, $transitionId);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'workflowId' => $model->workflowId, 'placeId' => $model->placeId, 'transitionId' => $model->transitionId]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Arc model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $workflowId
     * @param integer $placeId
     * @param integer $transitionId
     * @return mixed
     */
    public function actionDelete($workflowId, $placeId, $transitionId)
    {
        $this->findModel($workflowId, $placeId, $transitionId)->delete();

        return $this->redirect(['index','id'=>$workflowId]);
    }

    /**
     * Finds the Arc model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $workflowId
     * @param integer $placeId
     * @param integer $transitionId
     * @return Arc the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($workflowId, $placeId, $transitionId)
    {
        if (($model = Arc::findOne(['workflowId' => $workflowId, 'placeId' => $placeId, 'transitionId' => $transitionId])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
