<?php
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

if (!check_bitrix_sessid()) {
    return;
}

?>
<form action="<?echo $APPLICATION->GetCurPage()?>" style="display: flex; flex-direction: column; width: 30%">
    <?=bitrix_sessid_post()?>
    <input type="hidden" name="lang" value="<?echo LANGUAGE_ID?>">
    <input type="hidden" name="id" value="pd.tg">
    <input type="hidden" name="install" value="Y">
    <input type="hidden" name="step" value="2">
    <label style="margin: 5px 0px 0px 5px; font-weight: bold; font-size: 1rem" for="token">Токен бота</label>
    <input style="margin: 5px; height: 30px; padding-left: 10px" type="text" name="token">
    <label style="margin: 5px 0px 0px 5px;font-weight: bold; font-size: 1rem" for="chat_id">Chat ID</label>
    <input style="margin: 5px; height: 30px; padding-left: 10px" type="text" name="chat_id">
    <input style="margin: 10px 0px 0px 5px; border: 1px solid dimgray; height: 40px; color: black; font-weight: bold" type="submit" name="" value="Подтвердить">
</form>
