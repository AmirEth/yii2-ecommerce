<?php

namespace common\models\query;

use common\models\Category;

/**
 * This is the ActiveQuery class for [[\common\models\Category]].
 *
 * @see \common\models\Category
 */
class CategoryQuery extends \yii\db\ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return \common\models\Category[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }
    /**
     * {@inheritdoc}
     * @return \common\models\Category|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * Adds a condition to filter categories by their ID.
     *
     * @param int|array $id The category ID(s)
     * @return $this
     */
    public function byId($id)
    {
        return $this->andWhere(['id' => $id]);
    }

    /**
     * Includes products related to the categories.
     *
     * @return $this
     */
    public function withProducts()
    {
        return $this->with('products');
    }
}
