<?php
namespace PD\TG;

use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;

class TBotTable extends Entity\DataManager
{

    public static function getTableName()
    {
        return 'pd_tg';
    }

    public static function getMap()
    {
        return array(
            'ID' => array(
                'data_type' => 'integer',
                'primary' => true,
                'autocomplete' => true,
                'title' => "ID",
            ),
            'TOKEN' => array(
                'data_type' => 'string',
                'title' => "Token",
            ),
            'CHAT_ID' => array(
                'data_type' => 'string',
                'title' => "ID Chat",
            ),
        );
    }
}