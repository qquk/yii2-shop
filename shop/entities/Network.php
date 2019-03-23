<?php

namespace shop\entities;

use Webmozart\Assert\Assert;
use Yii;

/**
 * This is the model class for table "user_networks".
 *
 * @property integer $user_id
 * @property integer $identity
 * @property string $network
 */
class Network extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_networks';
    }

    public static function create($network, $identity): self
    {
        Assert::notEmpty($network);
        Assert::notEmpty($identity);

        $item = new static();
        $item->network = $network;
        $item->identity = $identity;

        return $item;

    }

    public function isFor($network, $identity): bool
    {
        return $this->network === $network && $this->identity === $identity;
    }

}
