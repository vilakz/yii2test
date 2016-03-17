<?php

namespace app\controllers;

use Yii;
use app\models\Product;
use app\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;


/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $_id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => (string)$model->_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => (string)$model->_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     *  Подготовить запрос (mongodb), который отберёт все товары, у которых емеется хотябы одна запись в объекте 'eav'
     * @return mixed
     */
    public function actionTest2() {
        
        $p = Product::find()->where([ '_eav' => [ '$size' => 0 ] ]);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $p,
            'pagination' => [
            'pageSize' => 10,
            ]
        ]);
        return $this->render('index2', [
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Подготовить запрос (mongodb), который отберёт все товары, у которых емеется атрибут 2 со значениями 255 и 256
     * @return type 
     */
    public function actionTest3() {
        
        $p = Product::find()->where([ '_eav.id' => 2 ,'_eav.value' => 255 , '_eav.value' => 256 ]);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $p,
            'pagination' => [
            'pageSize' => 10,
            ]
        ]);
        return $this->render('index2', [
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Подготовить запрос (mongodb), который отберёт все товары, у которых отсутствует атрибут 2
     * @return mixed 
     */
    public function actionTest4() {
        
        $p = Product::find()->where([ '_eav.id' => ['$nin' => [ 2 ]] ]);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $p,
            'pagination' => [
            'pageSize' => 10,
            ]
        ]);
        return $this->render('index2', [
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Реализовать метод в модели для коллекции product, который отберёт товары, у которых разнится один атрибут (то есть товары идентичны, за исключением одного параметра-атрибута из объекта 'eav')
     * @return mixed
     */
    public function actionTest5() {
        
        $p = Product::getHalfEqualItems();
        
        $dataProvider = new ArrayDataProvider([
            'allModels' => $p,
            'sort' => [
                'attributes' => ['id', 'name'],
            ],

            'pagination' => [
            'pageSize' => 10,
            ]
        ]);
        return $this->render('index2', [
            'dataProvider' => $dataProvider,
        ]);
    }
}
