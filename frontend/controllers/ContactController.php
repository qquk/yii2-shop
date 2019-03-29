<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 16.04.2018
 * Time: 23:35
 */

namespace frontend\controllers;


use shop\services\ContactService;
use shop\forms\ContactForm;
use RuntimeException;
use Yii;
use yii\web\Controller;

class ContactController extends Controller
{
    private $service;

    public function __construct($id, $module, ContactService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actionIndex()
    {
        $form = new ContactForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {

            try {
                $this->service->send($form);
                Yii::$app->session->setFlash('success', 'Thank you for contacting us');
                return $this->goHome();
            } catch (RuntimeException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }

            return $this->refresh();
        }

        return $this->render('index', [
            'model' => $form,
        ]);

    }
}