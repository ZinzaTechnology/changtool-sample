<?php
namespace common\models;

use yii\base\Model;
use yii\web\UploadedFile;

class Upload extends Model
{
    /**
     * @var UploadedFile
     */
    public $excelFile;

    public function rules()
    {
        return [
            [['excelFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xlsx'],
        ];
    }
    
    public function open()
    {
        if ($this->validate()) {
            return $this->excelFile->tempName;
        } else {
            return false;
        }
    }
}