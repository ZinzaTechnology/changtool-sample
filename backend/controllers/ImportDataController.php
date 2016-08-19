<?php

namespace backend\controllers;

use Yii;
use backend\controllers\BackendController;
use common\lib\logic\LogicImportData;

class ImportDataController extends BackendController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionQuestionAnswer()
    {
        if(Yii::$app->request->post()){
            $file = "uploads/TestExamData_2.xlsx";
            $logicImportData = new LogicImportData();
            $logicImportData->insertDataByFileExcel($file);
        }
        return $this->render('question-answer');
    }
}
