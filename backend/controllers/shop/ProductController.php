<?php

namespace backend\controllers\shop;


use shop\entities\Shop\Product\Product;
use shop\forms\manage\Shop\Product\ProductCreateForm;
use shop\useCases\Manage\Shop\ProductManageService;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ProductController extends Controller
{

    private $service;

    public function __construct($id, $module, ProductManageService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'activate' => ['POST'],
                    'draft' => ['POST'],
                    'delete-photo' => ['POST'],
                    'move-photo-up' => ['POST'],
                    'move-photo-down' => ['POST'],
                ],
            ],
        ];
    }

    public function actionView($id)
    {
        return $this->render('view', ['product' => $this->findModel($id)]);
    }

    public function actionCreate()
    {

        $form = new ProductCreateForm();

        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $product = $this->service->create($form);
                return $this->redirect(['view', 'id' => $product->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', ['model' => $form]);
    }

    public function findModel($id)
    {
        if (($model = Product::find()->where(['id' => $id])->one()) != null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


}