<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "alerta".
 *
 * @property int $id
 * @property double $latitude
 * @property double $longitude
 * @property string $data
 * @property int $visualizado
 * @property string $resposta
 * @property int $usuario_id
 * @property int $categoria_id
 *
 * @property Usuario $usuario
 * @property Categoria $categoria
 */
class Alerta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'alerta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['latitude', 'longitude', 'data', 'visualizado', 'usuario_id', 'categoria_id'], 'required'],
            [['latitude', 'longitude'], 'number'],
            [['data'], 'safe'],
            [['usuario_id', 'categoria_id'], 'integer'],
            [['visualizado'], 'number', 'max' => 1],
            [['resposta'], 'string', 'max' => 100],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usuario_id' => 'id']],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::className(), 'targetAttribute' => ['categoria_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'data' => 'Data',
            'visualizado' => 'Visualizado',
            'resposta' => 'Resposta',
            'usuario_id' => 'Usuario ID',
            'categoria_id' => 'Categoria ID',
        ];
    }

    public function init()
    {
        $this->data = (new \DateTime())->format('Y-m-d H:i:s');
        $this->visualizado = 0;
        $this->usuario_id = Yii::$app->user->identity->id;
    }

    public function extraFields()
    {
        return ['usuario', 'categoria'];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'usuario_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::className(), ['id' => 'categoria_id']);
    }
}
