<?php

include __DIR__."/../config/config.php";
include __DIR__."/../config/variables.php";
include_once __DIR__."/../functions/bot.php";
include_once __DIR__."/../functions/db.php";
include_once __DIR__."/../functions/functions.php";
include_once "api.php";
define('CACHE_DIR', __DIR__ . '/cache');

$API = new ServicesAPI('682DNYTNSGGZ6LNQSHIYQXA0DAPBFEYHVKR6YPMD');

if($data == "players_mas"){

# KF-Masters
$server_ip = '185.97.254.214:7744';

$cachetime = 25;

if (file_exists(CACHE_DIR . '/'.$server_ip.'_players.json') && time() - $cachetime < filemtime(CACHE_DIR.'/'.$server_ip.'_players.json')) {

	$server_players = json_decode(file_get_contents(CACHE_DIR.'/'.$server_ip.'_players.json'), true);

} else {
	
	$server_players = $API->method("server.players", array("address" => $server_ip));
	file_put_contents(CACHE_DIR.'/'.$server_ip.'_players.json', json_encode($server_players));
	
}

if (file_exists(CACHE_DIR . '/'.$server_ip.'.json') && time() - $cachetime < filemtime(CACHE_DIR.'/'.$server_ip.'.json')) {

	$server_info = json_decode(file_get_contents(CACHE_DIR.'/'.$server_ip.'.json'), true);

} else {
	
	$server_info = $API->method("server.get", array("address" => $server_ip));
	file_put_contents(CACHE_DIR.'/'.$server_ip.'.json', json_encode($server_info));
	
}

$arr = [];
foreach($server_players['result'] as $player){
  $arr[] = $player["name"];
}

$status = $server_info['result']['status'];

if($status == '1') {
    $players = implode (PHP_EOL, $arr);
}elseif($status == '0'){
    $players = 'Никого нет на сервере.';
}

$online = $server_info['result']['players']['now'];

if($online == '0'){
    $players = 'Никого нет на сервере.';
}
  
  bot('editMessageText',[
    'chat_id'=>$callbackchatid,
    'message_id'=>$callbackmessageid,
    'text'=>"🧟‍♀️ Список игроков на сервере KF-Masters

🌐 Игроки: 

<b>".$players."</b>",
    'parse_mode'=>'html',
    'reply_markup'=>json_encode(['inline_keyboard'=>[
    [
        ['text'=>"⬅️ Назад",'callback_data'=>"mas"]
    ],
    ],'resize_keyboard'=>true])
    ]);
}



#Masters

if($data == "players_hzd"){

# KF-Masters
$server_ip = '185.97.254.214:7144';

$cachetime = 25;

if (file_exists(CACHE_DIR . '/'.$server_ip.'_players.json') && time() - $cachetime < filemtime(CACHE_DIR.'/'.$server_ip.'_players.json')) {

	$server_players = json_decode(file_get_contents(CACHE_DIR.'/'.$server_ip.'_players.json'), true);

} else {
	
	$server_players = $API->method("server.players", array("address" => $server_ip));
	file_put_contents(CACHE_DIR.'/'.$server_ip.'_players.json', json_encode($server_players));
	
}

if (file_exists(CACHE_DIR . '/'.$server_ip.'.json') && time() - $cachetime < filemtime(CACHE_DIR.'/'.$server_ip.'.json')) {

	$server_info = json_decode(file_get_contents(CACHE_DIR.'/'.$server_ip.'.json'), true);

} else {
	
	$server_info = $API->method("server.get", array("address" => $server_ip));
	file_put_contents(CACHE_DIR.'/'.$server_ip.'.json', json_encode($server_info));
	
}

$arr = [];
foreach($server_players['result'] as $player){
  $arr[] = $player["name"];
}

$status = $server_info['result']['status'];

if($status == '1') {
    $players = implode (PHP_EOL, $arr);
}elseif($status == '0'){
    $players = 'Никого нет на сервере.';
}

$online = $server_info['result']['players']['now'];

if($online == '0'){
    $players = 'Никого нет на сервере.';
}
  
  bot('editMessageText',[
    'chat_id'=>$callbackchatid,
    'message_id'=>$callbackmessageid,
    'text'=>"🧟‍♀️ Список игроков на сервере KF-HzD

🌐 Игроки: 

<b>".$players."</b>",
    'parse_mode'=>'html',
    'reply_markup'=>json_encode(['inline_keyboard'=>[
    [
        ['text'=>"⬅️ Назад",'callback_data'=>"hzd"]
    ],
    ],'resize_keyboard'=>true])
    ]);
}

if($data == "players_mc"){

# KF-Masters
$server_ip = '185.97.254.214:7444';

$cachetime = 25;

if (file_exists(CACHE_DIR . '/'.$server_ip.'_players.json') && time() - $cachetime < filemtime(CACHE_DIR.'/'.$server_ip.'_players.json')) {

	$server_players = json_decode(file_get_contents(CACHE_DIR.'/'.$server_ip.'_players.json'), true);

} else {
	
	$server_players = $API->method("server.players", array("address" => $server_ip));
	file_put_contents(CACHE_DIR.'/'.$server_ip.'_players.json', json_encode($server_players));
	
}

if (file_exists(CACHE_DIR . '/'.$server_ip.'.json') && time() - $cachetime < filemtime(CACHE_DIR.'/'.$server_ip.'.json')) {

	$server_info = json_decode(file_get_contents(CACHE_DIR.'/'.$server_ip.'.json'), true);

} else {
	
	$server_info = $API->method("server.get", array("address" => $server_ip));
	file_put_contents(CACHE_DIR.'/'.$server_ip.'.json', json_encode($server_info));
	
}

$arr = [];
foreach($server_players['result'] as $player){
  $arr[] = $player["name"];
}

$status = $server_info['result']['status'];

if($status == '1') {
    $players = implode (PHP_EOL, $arr);
}elseif($status == '0'){
    $players = 'Никого нет на сервере.';
}

$online = $server_info['result']['players']['now'];

if($online == '0'){
    $players = 'Никого нет на сервере.';
}
  
  bot('editMessageText',[
    'chat_id'=>$callbackchatid,
    'message_id'=>$callbackmessageid,
    'text'=>"🧟‍♀️ Список игроков на сервере KF-Massacre

🌐 Игроки: 

<b>".$players."</b>",
    'parse_mode'=>'html',
    'reply_markup'=>json_encode(['inline_keyboard'=>[
    [
        ['text'=>"⬅️ Назад",'callback_data'=>"mc"]
    ],
    ],'resize_keyboard'=>true])
    ]);
}

?>