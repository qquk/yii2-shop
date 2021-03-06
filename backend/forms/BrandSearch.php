<?php

namespace backend\forms;


use shop\entities\Shop\Brand;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class BrandSearch extends Model
{
    public $id;

    public $name;

    public $slug;

    public function rules(): array
    {
        return [
            [['id'], 'integer'],
            [['name', 'slug'], 'safe'],
        ];
    }

    /**
     * @param $params request params
     * @return ActiveDataProvider
     */
    public function search($params): ActiveDataProvider
    {
        $query = Brand::find();

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort' => [
                'defaultOrder' => [
                    'name' => SORT_ASC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $provider;
        }

        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'name' , $this->name]);
        $query->andFilterWhere(['like', 'slug' , $this->slug]);

        return $provider;
    }
}