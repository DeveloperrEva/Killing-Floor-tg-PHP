<?php

include __DIR__."/../config/config.php";
include __DIR__."/../config/variables.php";
include_once __DIR__."/../functions/bot.php";
include_once __DIR__."/../functions/db.php";
include_once __DIR__."/../functions/functions.php";
include "servers.php";

if($data == "kf"){
     bot('editMessageText',[
          'chat_id'=>$callbackchatid,
            'message_id'=>$callbackmessageid,
          'text'=>"<b>🌐 Выберите сервер...</b>",
          'parse_mode'=>'html',
          'disable_web_page_preview'=>true,
          'reply_markup'=>json_encode(['inline_keyboard' => [
        [
            ['text' => "KF-Masters", 'callback_data' => "mas"],
            ['text' => "KF-HzD", 'callback_data' => "hzd"]
        ],
        [
            ['text' => "KF-Massacre", 'callback_data' => "mc"]
        ],
      ], 'resize_keyboard' => true])

        ]);
}


?>