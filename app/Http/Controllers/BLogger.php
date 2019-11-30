<?php

namespace App\Http\Controllers;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Illuminate\Log\Writer;
/**
 * 日志类
 */
class BLogger
{

    // 所有的LOG都要求在这里注册
    const LOG_ERROR = 'error';
    const LOG_INFO = 'info';

    private static $loggers = array();

    // 获取一个实例
    public static function getLogger($type = self::LOG_ERROR, $day = 30,$dir='')
    {
        if (empty(self::$loggers[$type])) {
            self::$loggers[$type] = new Writer(new Logger($type));
            self::$loggers[$type]->useDailyFiles(storage_path().'/logs/'.$dir. $type .'.log', $day);
        }

        $log = self::$loggers[$type];
        return $log;
    }

}