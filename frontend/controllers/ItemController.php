<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Item;
use frontend\models\ItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Statistic;
use yii\web\UploadedFile;

/**
 * ItemController implements the CRUD actions for Item model.
 */
class ItemController extends Controller
{
    /**
     * {@inheritdoc}
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
     * Lists all Item models.
     * @return mixed
     */
    public function actionIndex()
    {
 //     $this->actionRecord(Yii::$app->request);
        Yii::$app->CustomComponent->trigger(\common\components\CustomComponent::EVENT_AFTER);

        $searchModel = new ItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Item model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
//        $this->actionRecord(Yii::$app->request);
        Yii::$app->CustomComponent->trigger(\common\components\CustomComponent::EVENT_AFTER);

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionRecord($request){
        $statistic = new Statistic();
        $statistic->access_time = date('Y-m-d H:i:s');
        $statistic->user_ip = $request->userIP;
        $statistic->user_host = $request->hostInfo;
        $statistic->path_info = $request->pathInfo;
        $statistic->query_string = $request->queryString ? $request->queryString : 'tes';

        $statistic->save();
    }

    /**
     * Creates a new Item model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Item();

        $this->ItemSaveHandling($model);

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Item model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $this->ItemSaveHandling($model);

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Item model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Item model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Item the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Item::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function ItemSaveHandling(Item $model)
    {
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->upload = UploadedFile::getInstance($model, 'upload');

            if ($model->validate()){
                if ($model->upload){
                    $file_path = 'uploads/'.$model->upload->baseName.'-'.time().'.'.$model->upload->extension; 
                    if ($model->upload->saveAs($file_path)){
                        $model->picture = $file_path;
                    }
                }

                if($model->save(false)){
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
            
        }
    }
}
