<?php

include __DIR__."/../config/config.php";
include __DIR__."/../config/variables.php";
include_once __DIR__."/../functions/bot.php";
include_once __DIR__."/../functions/db.php";
include_once __DIR__."/../functions/functions.php";


////////////====[MUTE]====////////////
if(strpos($message, "/mute ") === 0 and $userId == $config['adminID']){
    $args = explode(" ", substr($message, 6));
    $userID = $args[0];
    $timer = $args[1];


    if(stripos($timer,'m')){
      $time = add_minutes(time(),$timer);
    }
    elseif(stripos($timer,'d')){
      $time = add_days(time(),$timer);
    }
    if(stripos($timer,'w')){
      $time = add_week(time(),$timer);
    }
    else{
    bot('sendmessage',[
        'chat_id'=>$chat_id,
        'text'=>muteUser($userID,$time),
	'parse_mode'=>'html',
	'reply_to_message_id'=> $message_id,
    ]);
    }
}

////////////====[UNMUTE]====////////////
if(strpos($message, "/unmute ") === 0 and $userId == $config['adminID']){
    $userID = substr($message, 8);   

    bot('sendmessage',[
        'chat_id'=>$chat_id,
        'text'=>unmuteUser($userID),
	'parse_mode'=>'html',
	'reply_to_message_id'=> $message_id,
    ]);

}

////////////====[BAN]====////////////
if(strpos($message, "/ban ") === 0 and $userId == $config['adminID']){
  $userID = substr($message, 5);   

  bot('sendmessage',[
      'chat_id'=>$chat_id,
      'text'=>banUser($userID),
'parse_mode'=>'html',
'reply_to_message_id'=> $message_id,
  ]);

}

////////////====[UNBAN]====////////////
if(strpos($message, "/unban ") === 0 and $userId == $config['adminID']){
  $userID = substr($message, 7);   

  bot('sendmessage',[
      'chat_id'=>$chat_id,
      'text'=>unbanUser($userID),
'parse_mode'=>'html',
'reply_to_message_id'=> $message_id,
  ]);

}

////////////====[HELPER]====////////////
if(strpos($message, "/admin") === 0 and $userId == $config['adminID']){
  bot('sendmessage',[
      'chat_id'=>$chat_id,
      'text'=>"<b>

/mute - Дать мут пользователю
    Ex:-    <code>/mute userID 10m - Мут на 10 минут
       /mute userID 10d - Мут на 10 дней</code>

/unmute - Размутить пользователя
    Ex:-    <code>/unmute userID - Размутить пользователя</code>

/ban - Заблокировать пользоваетеля
    Ex:-    <code>/ban userID - Заблокировать пользоваетеля</code>    
    
/unban - Unban a Banned user
    Ex:-    <code>/unban userID - Разаблокировать пользоваетеля</code>   
    
/mutelist - Посмотреть список замученных

/banlist - Посмотреть список забаненных

/botstats - Показывает статистику бота",
'parse_mode'=>'html',
'reply_to_message_id'=> $message_id,
  ]);

}

if(strpos($message, "/bc ") === 0 and $userId == $config['adminID']){
    
    $bc = substr($message, 4);

    $users_all = users_all($conn);

  foreach($users_all as $p){
    
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.telegram.org/bot'.$config['botToken'].'/sendMessage');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    $post = array(
      'chat_id'=>$p['userid'],
      'text'=>$bc,
      'parse_mode'=>'html',
      );
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_exec($ch);
  }
  logsummary("Рассылка завершена!");
}

////////////====[BANLIST]====////////////
if(strpos($message, "/banlist") === 0 and $userId == $config['adminID']){
   $banlist = fetchBanlist();

    if(!$banlist){
    bot('sendmessage',[
      'chat_id'=>$chat_id,
      'text'=>"<b>Вы еще никого не забанили.</b>",
      'parse_mode'=>'html',
      'reply_to_message_id'=> $message_id]);
   }

    foreach ($banlist as $result){
      $banuser = file_get_contents('Banned.txt');
		  $banuser .= $result."\n";
		  file_put_contents('Banned.txt',$banuser);
    }    

    $gettheuserfile = file_get_contents('Banned.txt');
	  $getmember = explode("\n",$gettheuserfile);
	  $getmem = count($getmember)-1;
	  $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.telegram.org/bot'.$config['botToken'].'/sendDocument');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    $post = array(
      'chat_id' => $chat_id,
      'caption' => "*Список заблокированных:* `$getmem`",
      'parse_mode' => "markdown",
      "reply_to_message_id"=> $message_id,
      'document' => new CURLFile(realpath('Banned.txt'))
      );
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_exec($ch);

    unlink('Banned.txt');

}

////////////====[MUTELIST]====////////////
if(strpos($message, "/mutelist") === 0 and $userId == $config['adminID']){
  $mutelist = fetchMutelist();

   if(!$mutelist){
   bot('sendmessage',[
     'chat_id'=>$chat_id,
     'text'=>"<b>Вы еще никого не замутили.</b>",
     'parse_mode'=>'html',
     'reply_to_message_id'=> $message_id]);
  }

   foreach ($mutelist as $result){
     $timer = fetchMuteTimer($result);
     $banuser = file_get_contents('Muted.txt');
     $banuser .= $result." Muted until ".date("F j, Y, g:i a",$timer['mute_timer'])."\n";
     file_put_contents('Muted.txt',$banuser);
   }    

   $gettheuserfile = file_get_contents('Muted.txt');
   $getmember = explode("\n",$gettheuserfile);
   $getmem = count($getmember)-1;
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, 'https://api.telegram.org/bot'.$config['botToken'].'/sendDocument');
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($ch, CURLOPT_POST, 1);
   $post = array(
     'chat_id' => $chat_id,
     'caption' => "*Список замученных:* `$getmem`",
     'parse_mode' => "markdown",
     "reply_to_message_id"=> $message_id,
     'document' => new CURLFile(realpath('Muted.txt'))
     );
   curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
   curl_exec($ch);

   unlink('Muted.txt');

}

if(strpos($message, "/botstats") === 0 and $userId == $config['adminID']){
    $querytotalrows	= 	mysqli_query($conn,"SELECT id FROM users WHERE id = (SELECT MAX(id) FROM users)");
		$fetchtotalrows = $querytotalrows->fetch_assoc();
		$totalrows = $fetchtotalrows['id'];

    bot('sendmessage',[
      'chat_id'=>$chat_id,
      'text'=>"≡ <b>Статистика:</b>

- <b>Всего пользователей:</b> ".$totalrows."",
      'parse_mode'=>'html',
      'reply_to_message_id'=> $message_id
  
    ]); 
}
?>