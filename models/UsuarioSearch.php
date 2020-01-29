<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Usuario;

/**
 * UsuarioSearch represents the model behind the search form of `app\models\Usuario`.
 */
class UsuarioSearch extends Usuario
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'intervalo_atualizacao', 'zoom_mapa', 'quantidade_alertas_visiveis_mapa'], 'integer'],
            [['login', 'senha', 'access_token', 'nome', 'telefone', 'super'], 'safe'],
            [['latitude_inicial_mapa', 'longitude_inicial_mapa'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Usuario::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'intervalo_atualizacao' => $this->intervalo_atualizacao,
            'zoom_mapa' => $this->zoom_mapa,
            'latitude_inicial_mapa' => $this->latitude_inicial_mapa,
            'longitude_inicial_mapa' => $this->longitude_inicial_mapa,
            'quantidade_alertas_visiveis_mapa' => $this->quantidade_alertas_visiveis_mapa,
        ]);

        $query->andFilterWhere(['like', 'login', $this->login])
            ->andFilterWhere(['like', 'senha', $this->senha])
            ->andFilterWhere(['like', 'access_token', $this->access_token])
            ->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'telefone', $this->telefone])
            ->andFilterWhere(['like', 'super', $this->super]);

        return $dataProvider;
    }
}
