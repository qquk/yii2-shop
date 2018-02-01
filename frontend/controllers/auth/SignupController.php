<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 31.01.2018
 * Time: 23:37
 */

namespace frontend\controllers\auth;


use yii\web\Controller;
use frontend\services\auth\SignupService;
use frontend\forms\SignupForm;
use Yii;

class SignupController extends Controller
{

    private $service;

    public function __construct($id, $module, SignupService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actionSignup()
    {

        $form = new SignupForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $user = $this->service->signup($form);
            if (Yii::$app->getUser()->login($user)) {
                return $this->goHome();
            }
        }

        return $this->render('signup', [
            'model' => $form,
        ]);
    }

    public function actionConfirm($token)
    {
        try {
           $this->service->confirm($token);
            Yii::$app->session->setFlash('success', 'Your email is confirmed.');
            return $this->redirect(['auth/auth/login']);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->goHome();
    }

}