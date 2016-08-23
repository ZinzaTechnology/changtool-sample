<?php

namespace backend\controllers;

use Yii;
use yii\web\UploadedFile;
use backend\controllers\BackendController;
use common\lib\logic\LogicImportData;
use common\models\Upload;

class ImportDataController extends BackendController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionQuestionAnswer()
    {
        $model = new Upload();
        if(Yii::$app->request->isPost){
            $model->excelFile = \yii\web\UploadedFile::getInstance($model, 'excelFile');
            try{
                $fileName = $model->open();
                $logicImportData = new LogicImportData();
                if($logicImportData->insertDataByFileExcel($fileName)){
                    $this->setSessionFlash('success', 'Import successful!');
                }
            } catch (Exception $ex) {
                throw $ex;
            }
        }
        return $this->render('question-answer', ['model' => $model]);
    }
}
