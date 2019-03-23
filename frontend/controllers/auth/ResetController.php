<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 16.04.2018
 * Time: 23:38
 */

namespace frontend\controllers\auth;


use shop\services\auth\PasswordResetService;
use yii\web\Controller;
use shop\forms\auth\PasswordResetRequestForm;
use shop\forms\auth\ResetPasswordForm;
use Yii;
use yii\web\BadRequestHttpException;

class ResetController extends Controller
{
    private $service;

    public function __construct($id, $module, PasswordResetService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actionRequestPasswordReset()
    {
        $form = new PasswordResetRequestForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->request($form);
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('request', [
            'model' => $form,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {

        try {
            $this->service->validateToken($token);
        } catch (\DomainException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        $form = new ResetPasswordForm();

        if ($form->load(Yii::$app->request->post() && $form->validate())) {
            try {
                $this->service->reset($token, $form);
                Yii::$app->session->setFlash('success', 'New password saved.');
                $this->goHome();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('resetPassword', [
            'model' => $form,
        ]);
    }

}