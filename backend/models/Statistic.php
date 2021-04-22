<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "statistic".
 *
 * @property int $id
 * @property string $access_time
 * @property string $user_ip
 * @property string $user_host
 * @property string $path_info
 * @property string $query_string
 */
class Statistic extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'statistic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['access_time', 'user_ip', 'user_host', 'path_info', 'query_string'], 'required'],
            [['access_time'], 'safe'],
            [['user_ip'], 'string', 'max' => 20],
            [['user_host', 'path_info', 'query_string'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'access_time' => 'Access Time',
            'user_ip' => 'User Ip',
            'user_host' => 'User Host',
            'path_info' => 'Path Info',
            'query_string' => 'Query String',
        ];
    }

    // public function actionRecord($request){

    //     //$this = new Statistic();
    //     $this->access_time = date('Y-m-d H:i:s');
    //     $this->user_ip = $request->userIP;
    //     $this->user_host = $request->hostInfo;
    //     $this->path_info = $request->pathInfo;
    //     $this->query_string = $request->queryString;

    //     $this->save();
    // }
}
