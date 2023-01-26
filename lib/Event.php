<?php
namespace PD\TG;
use http\Exception;
use \PD\TG\TBotTable;


class Event{
    protected $module;
    protected $type;
    protected $msg;
    protected $output;

    public function __construct(string $moduleName, string $type, $msg){
        $this->module = $moduleName;
        $this->type = $type;
        $this->msg = $msg;
    }

    public function send(bool $needFile = false){
        \Bitrix\Main\Loader::includeModule('pd.tg');
        $botData = TBotTable::getById(1)->Fetch();
        if($botData){
            if(!$needFile){
                $this->output = "<b>Модуль: </b>".$this->module."\n<b>Тип события: </b>".$this->type."\n<b>Сообщение: </b>\n".print_r($this->msg, true);
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
                $curlRes = curl_exec($curl);
                return $curlRes;
            }else{
                $this->output = "<b>Модуль: </b>".$this->module."\n<b>Тип события: </b>".$this->type;
                $file = time().'log.txt';
                $filename = $_SERVER['DOCUMENT_ROOT']. '/local/modules/pd.tg/files/'.$file;
                file_put_contents($filename, print_r($this->msg, true));
                $url = 'https://api.telegram.org/bot'.$botData["TOKEN"].'/sendDocument';
                $curl = curl_init();
                curl_setopt_array($curl,[
                    CURLOPT_POST=>1,
                    CURLOPT_RETURNTRANSFER=>1,
                    CURLOPT_TIMEOUT=>10,
                    CURLOPT_URL=>$url,
                    CURLOPT_POSTFIELDS=>[
                        'chat_id'=>$botData["CHAT_ID"],
                        'parse_mode'=>'html',
                        'caption'=>$this->output,
                        'document' => curl_file_create($filename, 'text/plain' , $file)
                    ],
                ]);
                $curlRes = curl_exec($curl);
                unlink($_SERVER['DOCUMENT_ROOT']. '/local/modules/pd.tg/files/'.$file);
                return $curlRes;
            }
        }else{
            throw new \Error("Bot params wasn't found. Reinstall module.");
        }
    }
}
