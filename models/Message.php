<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "message".
 *
 * @property integer $id
 * @property string $text
 * @property string $image
 * @property integer $answer_for_id
 * @property integer $topic_id
 *
 * @property Topic $topic
 */
class Message extends \yii\db\ActiveRecord
{
    public $imageFile;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author_name'], 'string', 'max' => 30],
            [['text', 'topic_id'], 'required'],
            [['answer_for_id', 'topic_id'], 'integer'],
            [['text'], 'string', 'max' => 500],
            [['image'], 'string', 'max' => 150],
            [['topic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Topic::className(), 'targetAttribute' => ['topic_id' => 'id']],
	    [['del_key'], 'integer'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
            'image' => 'Image',
            'answer_for_id' => 'Answer For ID',
            'topic_id' => 'Topic ID',
	    'del_key' => 'Del Key',
            'author_name' => 'Author name'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopic()
    {
        return $this->hasOne(Topic::className(), ['id' => 'topic_id']);
    }
    
     public function upload()
    {
        
            $this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            
    }
}
