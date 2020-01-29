<?php

namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use app\models\Alerta;
use yii\filters\auth\HttpBasicAuth;


class AlertaController extends ActiveController
{
    public $modelClass = 'app\models\Alerta';

    
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // remove authentication filter
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);
        
        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
        ];
        
        // re-add authentication filter
        $behaviors['authenticator'] = $auth;
        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
        $behaviors['authenticator']['except'] = ['options'];
        $behaviors['authenticator']['class'] = HttpBasicAuth::className();

        // $behaviors['authenticator'] = [
        //     'class' => HttpBasicAuth::className(),
        // ];
        return $behaviors;
    }


    public function actions()
    {
        $actions = parent::actions();
        unset($actions['delete']);
        return $actions;
    }


    public function checkAccess($action, $model = null, $params = [])
    {
        if ($action === 'view' || $action === 'update')
        {
            if($model->usuario_id !== \Yii::$app->user->identity->id && !(\Yii::$app->user->identity->super))
            {
                throw new \yii\web\ForbiddenHttpException('Você não tem permissão para realizar esta ação.');
            }
        }

        if ($action === 'index')
        {
            if(!(\Yii::$app->user->identity->super))
            {
                throw new \yii\web\ForbiddenHttpException('Você não tem permissão para realizar esta ação.');
            }
        }
    }


    public function actionRecuperarUltimosAlertas()
    {
        $get = Yii::$app->request->get();

        $alertas = Alerta::find()->where(['>=', 'data', $get['dataInicial']])->all();

        return $alertas;
    }
}
