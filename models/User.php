<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\db\Expression;
use app\components\telegrambot\Objects\User as TelegramUser;

/**
 * User model
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $city
 * @property double $lat
 * @property double $lng
 * @property integer $created
 */
class User extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created',
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'first_name', 'last_name'], 'filter', 'filter' => 'trim'],
            [['user_id', 'first_name'], 'required'],
            [['user_id'], 'integer'],
            [['user_id'], 'unique'],
            [['first_name', 'last_name'], 'string', 'length' => [1, 255]],
//            [['last_cities'], 'string'],
//            [['lat', 'lng'], 'double'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @param \app\components\telegrambot\Objects\User $from
     * @return User
     * @throws \Exception
     */
    public static function getUser(TelegramUser $from)
    {
        if (empty($from) || empty($from->getId())) {
            throw new \InvalidArgumentException('Sender is empty');
        }
        $user = self::findOne(['user_id' => $from->getId()]);

        if (empty($user)) {
            $user = new User();
            $user->user_id = $from->getId();
            $user->first_name = $from->getFirstName();
            $user->last_name = $from->getLastName();
            if ($user->validate()) {
                $user->save();
            } else {
                $errorMessages = json_encode($user->getErrors());
                $message = "Can not create new user with user_id='{$from->getId()}' and first_name='{$from->getFirstName()}' ({$errorMessages})";
                throw new Exception($message);
            }
        }

        return $user;
    }

    /**
     * @return bool
     */
    public function hasLocation()
    {
        return !empty($this->city) || (!empty($this->lat) && !empty($this->lng));
    }
}
