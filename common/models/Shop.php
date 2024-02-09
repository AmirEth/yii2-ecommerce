<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "{{%shops}}".
 *
 * @property int         $id
 * @property string      $shop_name
 * @property string|null $description
 * @property string|null $image
 * @property string|null $logo
 * @property string|null $tags
 * @property string|null $opening_days
 * @property int|null    $shop_status
 * @property float|null  $average_rating
 * @property string|null $category
 * @property string|null $social_media_links
 * @property int|null    $user_id
 * @property int         $cif
 *
 * @property User        $user
 */
class Shop extends \yii\db\ActiveRecord
{
    /**
     * @var \yii\web\UploadedFile
     */
    public $imageFile;

    /**
     * @var \yii\web\UploadedFile
     */
    public $logoFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%shops}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['shop_name', 'cif'], 'required'],
            [['description', 'opening_days', 'social_media_links','tags'], 'string'],
            [['shop_status', 'user_id', 'cif'], 'integer'],
            [['average_rating'], 'number'],
            [['shop_name', 'image', 'logo', 'category'], 'string', 'max' => 255],
            [['imageFile', 'logoFile'], 'image', 'extensions' => 'png, jpg, jpeg, webp', 'maxSize' => 10 * 1024 * 1024],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'               => 'ID',
            'shop_name'        => 'Shop Name',
            'description'      => 'Description',
            'image'            => 'Image',
            'logo'             => 'Logo',
            'tags'             => 'Tags',
            'opening_days'     => 'Opening Days',
            'shop_status'      => 'Shop Status',
            'average_rating'   => 'Average Rating',
            'category'         => 'Category',
            'social_media_links' => 'Social Media Links',
            'user_id'          => 'User ID',
            'cif'              => 'Cif',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ShopQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ShopQuery(get_called_class());
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->imageFile) {
            $this->image = '/shops/' . Yii::$app->security->generateRandomString() . '/' . $this->imageFile->name;
        }

        if ($this->logoFile) {
            $this->logo = '/shops/' . Yii::$app->security->generateRandomString() . '/' . $this->logoFile->name;
        }

        $transaction = Yii::$app->db->beginTransaction();
        $ok = parent::save($runValidation, $attributeNames);

        if ($ok && $this->imageFile) {
            $fullPath = Yii::getAlias('@frontend/web/storage') . $this->image;
            $dir = dirname($fullPath);
            if (!FileHelper::createDirectory($dir) | !$this->imageFile->saveAs($fullPath)) {
                $transaction->rollBack();

                return false;
            }
        }

        if ($ok && $this->logoFile) {
            $fullPath = Yii::getAlias('@frontend/web/storage') . $this->logo;
            $dir = dirname($fullPath);
            if (!FileHelper::createDirectory($dir) | !$this->logoFile->saveAs($fullPath)) {
                $transaction->rollBack();

                return false;
            }
        }

        $transaction->commit();

        return $ok;
    }

    public function getImageUrl()
    {
        return self::formatImageUrl($this->image);
    }

    public function getLogoUrl()
    {
        return self::formatImageUrl($this->logo);
    }

    public static function formatImageUrl($imagePath)
    {
        if ($imagePath) {
            return Yii::$app->params['frontendUrl'] . '/storage' . $imagePath;
        }

        return Yii::$app->params['frontendUrl'] . '/img/no_image_available.png';
    }

    public function afterDelete()
    {
        parent::afterDelete();
        if ($this->image) {
            $dir = Yii::getAlias('@frontend/web/storage') . dirname($this->image);
            FileHelper::removeDirectory($dir);
        }

        if ($this->logo) {
            $dir = Yii::getAlias('@frontend/web/storage') . dirname($this->logo);
            FileHelper::removeDirectory($dir);
        }
    }
    public function getFormattedOpeningDays()
    {
        $daysMapping = [
            'Monday' => 'Mon',
            'Tuesday' => 'Tue',
            'Wednesday' => 'Wed',
            'Thursday' => 'Thu',
            'Friday' => 'Fri',
            'Saturday' => 'Sat',
            'Sunday' => 'Sun',
        ];
    
        $openingDays = json_decode($this->opening_days, true);
    
        if ($openingDays && is_array($openingDays)) {
            $formattedDays = [];
    
            foreach ($openingDays as $day => $hours) {
                $formattedDays[] = "$daysMapping[$day] $hours";
            }
    
            $formattedString = implode(', ', $formattedDays);
    
            // Convert "Mon, Tue, Wed" to "Mon to Wed"
            $formattedString = preg_replace('/\b(\w+)-\w+(, \1\b)+/', '$1 to $1', $formattedString);
    
            // Convert "Mon to Wed, Fri" to "Mon to Wed and Fri"
            $formattedString = preg_replace('/(\w+ to \w+, )+\w+/', '$1and $3', $formattedString);
    
            return $formattedString;
        }
    
        return '';
    }
}
