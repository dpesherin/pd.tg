<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Application;
use Bitrix\Main\IO\Directory;
use PD\TG\TBotTable;

Loc::loadMessages(__FILE__);

class pd_tg extends CModule{

    public $MODULE_ID = "pd.tg";
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $error;

    public function __construct(){
        if (is_file(__DIR__."/version.php")){
            include_once(__DIR__."/version.php");
            $this->MODULE_VERSION = $arVersion["VERSION"];
            $this->MODULE_VERSION_DATE = $arVersion["VERSION_DATE"];
            $this->MODULE_NAME = Loc::getMessage("PD_NAME");
            $this->MODULE_DESCRIPTION = Loc::getMessage("PD_DESCRIPTION");
        }else{
            CAdminMessage::ShowMessage(
                Loc::getMessage("MODULE_FILE_NOT_FOUND")." version.php"
            );
        }
    }

    public function InstallDB()
    {
        global $DB;
        $this->error = false;
        $this->error = $DB->RunSQLBatch($_SERVER['DOCUMENT_ROOT']."/local/modules/pd.tg/install/db/install.sql");
        if(!$this->error){
            return true;
        }else{
            return $this->error;
        }
    }

    public function UnInstallDB()
    {
        global $DB;
        $this->error = false;
        $this->error = $DB->RunSQLBatch($_SERVER['DOCUMENT_ROOT']."/local/modules/pd.tg/install/db/uninstall.sql");
        if(!$this->error){
            return true;
        }else{
            return $this->error;
        }
    }

    public function InstallEvents()
    {
        return true;
    }

    public function UnInstallEvents()
    {
        return true;
    }

    public function InstallFiles()
    {
        return true;
    }

    public function UnInstallFiles()
    {
        return true;
    }

    public function DoInstall()
    {
        global $APPLICATION;

        $context = Application::getInstance()->GetContext();
        $request = $context->GetRequest();

        if($request['step']<2){
            $APPLICATION->includeAdminFile(
                Loc::getMessage("PD_INSTALL_TITLE")." <<".Loc::getMessage("PD_NAME").">>",
                __DIR__.'/step.php'
            );
        }elseif ($request['step'] == 2){
            if($request['token'] && $request['chat_id']){
                if(CheckVersion(ModuleManager::getVersion("main"), '14.00.00')){
                    $this->InstallFiles();
                    $this->InstallEvents();
                    $this->InstallDB();
                    ModuleManager::registerModule($this->MODULE_ID);

                    \Bitrix\Main\Loader::includeModule('pd.tg');
                    $arFields=[
                        "TOKEN"=>$request["token"],
                        "CHAT_ID"=>$request["chat_id"]
                    ];
                    TBotTable::add($arFields);
                    $APPLICATION->includeAdminFile(
                        Loc::getMessage("PD_INSTALL_TITLE")." <<".Loc::getMessage("PD_NAME").">>",
                        __DIR__.'/step2.php'
                    );
                }else{
                    CAdminMessage::ShowMessage(
                        Loc::getMessage("PD_TG_INSTALL_ERR")
                    );
                    return;
                }
            }
        }

    }

    public function DoUninstall()
    {
        global $APPLICATION;

        $this->UnInstallFiles();
        $this->UnInstallEvents();
        $this->UnInstallDB();

        ModuleManager::unRegisterModule($this->MODULE_ID);
        $APPLICATION->includeAdminFile(
            Loc::getMessage('PD_UNINSTALL_TITLE').' «'.Loc::getMessage('PD_NAME').'»',
            __DIR__.'/unstep.php'
        );
    }
}
