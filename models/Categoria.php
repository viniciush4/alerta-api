<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categoria".
 *
 * @property int $id
 * @property string $nome
 * @property int $categoria_pai_id
 *
 * @property Alerta[] $alertas
 * @property Categoria $categoriaPai
 * @property Categoria[] $categorias
 */
class Categoria extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categoria';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome'], 'required'],
            [['categoria_pai_id'], 'integer'],
            [['nome'], 'string', 'max' => 100],
            [['categoria_pai_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::className(), 'targetAttribute' => ['categoria_pai_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'categoria_pai_id' => 'Categoria Pai ID',
        ];
    }

    public function fields()
    {
        $fields = parent::fields();

        // remove os atributos sensíveis
        unset($fields['categoria_pai_id']);

        return $fields;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlertas()
    {
        return $this->hasMany(Alerta::className(), ['categoria_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoriaPai()
    {
        return $this->hasOne(Categoria::className(), ['id' => 'categoria_pai_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategorias()
    {
        return $this->hasMany(Categoria::className(), ['categoria_pai_id' => 'id']);
    }
}
