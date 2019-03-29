<?php

namespace backend\controllers\shop;

use backend\forms\BrandSearch;
use shop\entities\Shop\Brand;
use shop\forms\manage\Shop\BrandForm;
use shop\useCases\Manage\Shop\BrandManageService;
use yii\base\Module;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class BrandController extends Controller
{

    private $service;

    public function __construct(string $id, Module $module, BrandManageService $service, array $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    public function behaviors(): array
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

    public function actionIndex()
    {
        $searchForm = new BrandSearch();
        $provider = $searchForm->search(\Yii::$app->request->queryParams);

        return $this->render('index', ['provider' => $provider, 'searchForm' => $searchForm]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', ['brand' => $model]);
    }


    public function actionCreate()
    {
        $form = new BrandForm();

        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $brand = $this->service->create($form);
                return $this->redirect(['view', 'id' => $brand->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            };
        }
        return $this->render('create', ['model' => $form]);
    }

    public function actionUpdate($id)
    {
        $brand = $this->findModel($id);
        $form = new BrandForm($brand);

        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($id, $form);
                return $this->redirect(['view', 'id' => $brand->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            };
        }
        return $this->render('update', ['model' => $form, 'brand' => $brand]);

    }

    public function actionDelete($id)
    {

        try {
            $this->service->remove($id);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        };
        return $this->redirect(['index']);
    }


    public function findModel($id)
    {
        if (($model = Brand::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}