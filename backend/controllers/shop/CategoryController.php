<?php

namespace backend\controllers\shop;


use backend\forms\CategorySearch;
use shop\entities\Shop\Category;
use shop\forms\manage\Shop\CategoryForm;
use shop\useCases\Manage\Shop\CategoryManageService;
use yii\base\Module;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CategoryController extends Controller
{
    private $service;

    public function __construct(string $id, Module $module, CategoryManageService $service, array $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    public function actionView($id)
    {
        return $this->render('view', ['category' => $this->findModel($id)]);

    }

    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $form = new CategoryForm();

        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $category = $this->service->create($form);
                $this->redirect(['view', 'id' => $category->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('create', ['model' => $form]);
    }

    public function actionUpdate($id)
    {
        $category = $this->findModel($id);
        $form = new CategoryForm();

        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($category->id, $form);
                $this->redirect(['view', 'id' => $category->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', ['model' => $form, 'category' => $category]);
    }

    public function actionMoveUp($id)
    {
        try {
            $this->service->moveUp($id);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        $this->redirect(['index']);
    }

    public function actionMoveDown($id)
    {
        try {
            $this->service->moveDown($id);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        $this->redirect(['index']);
    }


    public function findModel($id)
    {
        if ($category = Category::findOne($id)) {
            return $category;
        }
        throw new NotFoundHttpException("The requested page not found");
    }

}