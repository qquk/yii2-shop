<?php

namespace backend\controllers\shop;

use backend\forms\TagSearch;
use shop\entities\Shop\Product\Product;
use shop\entities\Shop\Tag;
use shop\forms\manage\Shop\Product\TagsForm;
use shop\forms\manage\Shop\TagForm;
use shop\useCases\Manage\Shop\TagManageService;
use yii\base\Module;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class TagController extends Controller
{
    private $service;

    public function __construct(string $id, Module $module, TagManageService $service, array $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        $searchForm = new TagSearch();
        $provider = $searchForm->search(\Yii::$app->request->queryParams);

        return $this->render('index', ['provider' => $provider, 'searchForm' => $searchForm]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', ['tag' => $model]);
    }

    public function actionCreate()
    {
        $form = new TagForm();
        $tags = new TagsForm(Product::findOne(4));
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $tag = $this->service->crete($form);
                $this->redirect(['view', 'id' => $tag->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', ['model' => $form, 'tags' => $tags]);
    }

    public function actionUpdate($id)
    {
        $tag = $this->findModel($id);
        $form = new TagForm($tag);

        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($id, $form);
                return $this->redirect(['view', 'id' => $tag->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            };
        }
        return $this->render('update', ['model' => $form, 'tag' => $tag]);

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
        if (($model = Tag::find()->where(['id' => $id])->one()) != null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}