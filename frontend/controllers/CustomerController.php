<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Customer;
use frontend\models\CustomerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\User;
use frontend\models\Order;
use frontend\models\OrderSearch;
use frontend\model\OrderItem;

/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class CustomerController extends Controller
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
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Customer model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Customer();

        $userId = Yii::$app->user->id;

        $user = $model->findOne(['user_id' => $userId]);
        $hadCreated = false;

        if(!$user) {
            if ($model ->load(Yii::$app->request->post())){
                $model->user_id = $userId;
                $model->save();
                return $this->redirect(['view', 'id' => $model -> id]);
            }

        } else{
            $hadCreated = true;
        }
        // $logged_user = User::findOne(Yii::$app->user->id);

        // //print_r($logged_user->customer); die();

        // if(count($logged_user->customer)>=1){
        //     $model = null;
        //     return $this->render('create', [
        //         'model' => $model, 
        //     ]);
        // }

        
        $model->user_id=Yii::$app->user->id;    

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Customer model.
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


    public function actionShowOrder()
    {
        $all_order = Order::find()->with('customer')->with('orderItems')->with('orderItems.item');
        //print_r($all_order->all());die();

        return $this->render('show-order', [
            'dataProvider' => $all_order,
        ]);

        $searchModel = new CustomerSearch();
        $dataProvider =$searchModel->search(Yii::$app->$request->queryParams);

        return $this->render('show-order', [
            'searchModel' => $searchModel,
            'dataprovider' => $dataProvider,
        ]);
    }

    /**
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
