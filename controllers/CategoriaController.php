<?php

namespace app\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use app\models\Categoria;
use yii\filters\auth\HttpBasicAuth;


class CategoriaController extends ActiveController
{
    public $modelClass = 'app\models\Categoria';

    
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // remove authentication filter
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);
        
        // // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
        ];
        
        // // re-add authentication filter
        $behaviors['authenticator'] = $auth;
        // // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
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
        if ($action !== 'index' && $action !== 'view')
        {
            if(!(\Yii::$app->user->identity->super))
            {
                throw new \yii\web\ForbiddenHttpException('Você não tem permissão para realizar esta ação.');
            }
        }
    }


    public function actionDelete()
    {
        $get = \Yii::$app->request->get();

        $categoria = Categoria::findOne($get);

        if($categoria){
            $categoria->delete();
        } else {
            throw new \Exception('Categoria inexistente.');
        }
    }
}
