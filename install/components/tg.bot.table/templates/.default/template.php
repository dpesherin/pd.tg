<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Localization\Loc;
use \PD\TG\TBotTable;

Loc::loadMessages(__FILE__);

\CJSCore::Init(["jquery"]);

$this->addExternalCss($_SERVER["DOCUMENT_ROOT"].'./local/modules/pd.tg/assets/bootstrap/css/bootstrap-grid.min.css');
$this->addExternalJs($_SERVER["DOCUMENT_ROOT"].'./local/modules/pd.tg/assets/bootstrap/js/bootstrap.min.js');

?>

<div class="container">
    <h1 class="mb-2"><?= Loc::getMessage('BOT_LIST')?></h1>
    <?
        foreach ($arResult['bots'] as $bot){
            ?>
            <div class="row">
                <div class="cell">
                    <p class="id">
                        <?$bot['ID']?>
                    </p>
                </div>
                <div class="cell">
                    <p class="token">
                        <?$bot['TOKEN']?>
                    </p>
                </div>
                <div class="cell">
                    <p class="chat">
                        <?$bot['CHAT_ID']?>
                    </p>
                </div>
            </div>
        <?
        }
    ?>

</div>