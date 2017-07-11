<?php

namespace app\models;
use  creocoder\nestedsets\NestedSetsQueryBehavior;
/**
 * This is the ActiveQuery class for [[Categorytree]].
 *
 * @see Categorytree
 */
class CategorytreeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    public function behaviors() {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     * @return Categorytree[]|array
     */ /*
    public function all($db = null)
    {
        return parent::all($db);
    }
*/
    /**
     * @inheritdoc
     * @return Categorytree|array|null
     */
  /*  public function one($db = null)
    {
        return parent::one($db);
    }*/
}
