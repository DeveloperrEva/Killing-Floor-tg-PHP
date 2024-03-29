    <?php

    include __DIR__."/config/config.php";
    include __DIR__."/config/variables.php";
    include __DIR__."/functions/bot.php";
    include __DIR__."/functions/functions.php";
    include __DIR__."/functions/db.php";

    date_default_timezone_set($config['timeZone']);

    include __DIR__."/modules/admin.php";
    include __DIR__."/modules/checker/servers.php";
    include __DIR__."/modules/checker/kf.php";

    if(strpos($message, "/start") === 0){
        addUser($userId);
        bot('sendmessage',[
            'chat_id'=>$chat_id,
            'text'=>"<b>🙋🏻‍♂️ Добро пожаловать в бота для мониторинга серверов KF Sunrise Project</b> ",
    	'parse_mode'=>'html',
    	'reply_to_message_id'=> $message_id,
    	'disable_web_page_preview'=>true,
        'reply_markup'=>json_encode(['inline_keyboard' => [
            [
                ['text' => "ℹ️ Список серверов ℹ️", 'callback_data' => "kf"]
            ],
          ], 'resize_keyboard' => true])
        ]);
        logsummary("Пользователь запустил бота -> @$username -> $userId");
      }


    ?>
