<?php
namespace PD\TG;
use http\Exception;
use \PD\TG\TBotTable;


class Event{
    protected $module;
    protected $type;
    protected $msg;
    protected $output;

    public function __construct(string $moduleName, string $type, string $msg){
        $this->module = $moduleName;
        $this->type = $type;
        $this->msg = $msg;
        $this->output = "<b>Модуль: </b>".$this->module."\n<b>Тип события: </b>".$this->type."\n<b>Сообщение: </b>\n".$this->msg;
    }

    public function send(){
        \Bitrix\Main\Loader::includeModule('pd.tg');
        $botData = TBotTable::getById(1)->Fetch();
        if($botData){
            $url = 'https://api.telegram.org/bot'.$botData["TOKEN"].'/sendMessage';
            $curl = curl_init();
            curl_setopt_array($curl,[
                CURLOPT_POST=>1,
                CURLOPT_RETURNTRANSFER=>1,
                CURLOPT_TIMEOUT=>10,
                CURLOPT_URL=>$url,
                CURLOPT_POSTFIELDS=>[
                    'chat_id'=>$botData["CHAT_ID"],
                    'parse_mode'=>'html',
                    'text'=>$this->output
                ],
            ]);
            return curl_exec($curl);
        }else{
            throw new \Error("Bot params wasn't found. Reinstall module.");
        }
    }
}
