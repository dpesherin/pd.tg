<?php
Bitrix\Main\Loader::registerAutoloadClasses(
    "pd.tg",
    array(
        "PD\\TG\\TBotTable" => "lib/TBot.php",
        "PD\\TG\\Event"=>"lib/Event.php"
    )
);
