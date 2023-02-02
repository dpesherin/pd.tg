<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException;
use Bitrix\Main\Engine\ActionFilter;
use Bitrix\Main\Error;
use Bitrix\Main\ErrorCollection;
use \PD\TG\TBotTable;

if(!Loader::includeModule('ctrl.rosfinmonitoring')) {
    ShowError('Модуль Бот Телеграмм не установлен!');
    return;
}

class BotData extends CBitrixComponent{
    public function onPrepareComponentParams($arParams)
    {
        return $arParams;
    }
    public function executeComponent()
    {
        $arBot = [];
        $arParams = [
            "select"=>["*"],
            "filter"=>[">ID"=>0]
        ];
        $res = \PD\TG\TBotTable::getList($arParams);
        while($data=$res->Fetch()){
            $arBot[]= $data;
        }
        $this->arResult = $arBot;


        $this->includeComponentTemplate();
    }
}