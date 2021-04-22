<?php
namespace common\components;

use backend\models\Statistic;
use yii\base\Component;

class CustomComponent extends Component{
    const EVENT_AFTER = "event-after";

    public function actionRecord(){
        $request = \Yii::$app->request;
        $statistic = new Statistic();
        $statistic->access_time = date('Y-m-d H:i:s');
        $statistic->user_ip = $request->userIP;
        $statistic->user_host = $request->hostInfo;
        $statistic->path_info = $request->pathInfo;
        $statistic->query_string = $request->queryString ? $request->queryString : 'tes';

        $statistic->save();
    }
}


?>