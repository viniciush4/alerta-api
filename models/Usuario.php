<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario".
 *
 * @property int $id
 * @property string $login
 * @property string $senha
 * @property string $access_token
 * @property string $nome
 * @property string $telefone
 * @property int $super
 * @property int $intervalo_atualizacao
 * @property int $zoom_mapa
 * @property double $latitude_inicial_mapa
 * @property double $longitude_inicial_mapa
 * @property int $quantidade_alertas_visiveis_mapa
 *
 * @property Alerta[] $alertas
 */
class Usuario extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['login', 'senha', 'nome', 'telefone', 'super', 'intervalo_atualizacao', 'zoom_mapa', 'latitude_inicial_mapa', 'longitude_inicial_mapa', 'quantidade_alertas_visiveis_mapa'], 'required'],
            [['intervalo_atualizacao', 'zoom_mapa', 'quantidade_alertas_visiveis_mapa'], 'integer'],
            [['latitude_inicial_mapa', 'longitude_inicial_mapa'], 'number'],
            [['login', 'senha', 'nome'], 'string', 'max' => 100],
            [['access_token'], 'string', 'max' => 500],
            [['telefone'], 'string', 'max' => 14],
            [['super'], 'number', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Login',
            'senha' => 'Senha',
            'access_token' => 'Access Token',
            'nome' => 'Nome',
            'telefone' => 'Telefone',
            'super' => 'Super',
            'intervalo_atualizacao' => 'Intervalo Atualizacao',
            'zoom_mapa' => 'Zoom Mapa',
            'latitude_inicial_mapa' => 'Latitude Inicial Mapa',
            'longitude_inicial_mapa' => 'Longitude Inicial Mapa',
            'quantidade_alertas_visiveis_mapa' => 'Quantidade Alertas Visiveis Mapa',
        ];
    }

    public function init()
    {
        $this->intervalo_atualizacao = 1;
        $this->zoom_mapa = 10;
        $this->latitude_inicial_mapa = 10;
        $this->longitude_inicial_mapa = 10;
        $this->quantidade_alertas_visiveis_mapa = 10;
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if(Yii::$app->controller->action->id !== 'login'){
            $this->senha = sha1($this->senha);
        }

        return true;
    }
    
    public function fields()
    {
        $fields = parent::fields();

        // remove os atributos sensíveis
        unset($fields['login'], $fields['senha']);

        return $fields;
    }

    public function extraFields()
    {
        return ['alertas'];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlertas()
    {
        return $this->hasMany(Alerta::className(), ['usuario_id' => 'id']);
    }

    /**
    * @inheritdoc
    */
    public static function findIdentity($id)
    {
        $usuario = Usuario::find()->where(['id' => $id])->one();

        if ($usuario) {
            return new static($usuario);
        }

        return null;
    }
    
    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }
    
    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $usuario = Usuario::find()->where(['login' => $username])->one();

        if ($usuario) {
            return new static($usuario);
        }

        return null;
    }
    
    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return null;
    }
    
    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return null;
    }
    
    /**
     * Validate password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->senha === sha1($password);
    }
}
