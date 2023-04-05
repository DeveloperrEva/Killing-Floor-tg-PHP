<?php

include __DIR__."/../config/config.php";
include __DIR__."/../config/variables.php";
include_once __DIR__."/../functions/bot.php";
include_once __DIR__."/../functions/db.php";
include_once __DIR__."/../functions/functions.php";
include_once "api.php";
include "players.php";
define('CACHE_DIR', __DIR__ . '/cache');

$API = new ServicesAPI('682DNYTNSGGZ6LNQSHIYQXA0DAPBFEYHVKR6YPMD');

if($data == "mas"){

# KF-Masters
$server_ip = '185.97.254.214:7744';

# ставим кеш на 1 мин (60 сек)
$cachetime = 25;

if (file_exists(CACHE_DIR . '/'.$server_ip.'.json') && time() - $cachetime < filemtime(CACHE_DIR.'/'.$server_ip.'.json')) {

	$server_info = json_decode(file_get_contents(CACHE_DIR.'/'.$server_ip.'.json'), true);

} else {
	
	$server_info = $API->method("server.get", array("address" => $server_ip));
	file_put_contents(CACHE_DIR.'/'.$server_ip.'.json', json_encode($server_info));
	
}

#Masters
$map = $server_info['result']['map']['name'];
$ip = $server_info['result']['address'];
$online = $server_info['result']['players']['now'];
$max = $server_info['result']['players']['max'];
$status = $server_info['result']['status'];

if($status == '1') {
    $status = '✅ Работает';
}elseif($status == '0'){
    $status = '❌ Не работает';
}

if (preg_match_all("/[A-Z].*/", $map, $matches)){
    $replace = $matches[0][0];

    bot('editMessageText',[
    'chat_id'=>$callbackchatid,
    'message_id'=>$callbackmessageid,
    'text'=>"🧟‍♀️ Сервер KF-Masters

🌐 IP-Адрес: $ip

💠 Статус сервера: <b>$status</b>

🃏 Карта: <b>$replace</b>

👤Игроков онлайн: <b>$online</b>/<b>$max</b>",
    'parse_mode'=>'html',
    'reply_markup'=>json_encode(['inline_keyboard'=>[
    [
        ['text'=>"Список игроков",'callback_data'=>"players_mas"]
    ],
    [
        ['text'=>"⬅️ Назад",'callback_data'=>"kf"]
    ],
    ],'resize_keyboard'=>true])
    ]);
}
}

if($data == "hzd"){

# KF-Masters
$server_ip = '185.97.254.214:7144';

# ставим кеш на 1 мин (60 сек)
$cachetime = 25;

if (file_exists(CACHE_DIR . '/'.$server_ip.'.json') && time() - $cachetime < filemtime(CACHE_DIR.'/'.$server_ip.'.json')) {

	$server_info = json_decode(file_get_contents(CACHE_DIR.'/'.$server_ip.'.json'), true);

} else {
	
	$server_info = $API->method("server.get", array("address" => $server_ip));
	file_put_contents(CACHE_DIR.'/'.$server_ip.'.json', json_encode($server_info));
	
}

#Masters

#Masters
$map = $server_info['result']['map']['name'];
$ip = $server_info['result']['address'];
$online = $server_info['result']['players']['now'];
$max = $server_info['result']['players']['max'];
$status = $server_info['result']['status'];

if($status == '1') {
    $status = '✅ Работает';
}elseif($status == '0'){
    $status = '❌ Не работает';
}

if (preg_match_all("/[A-Z].*/", $map, $matches)){
    $replace = $matches[0][0];

    bot('editMessageText',[
    'chat_id'=>$callbackchatid,
    'message_id'=>$callbackmessageid,
    'text'=>"🧟‍♀️ Сервер KF-HzD

🌐 IP-Адрес: $ip

💠 Статус сервера: <b>$status</b>

🃏 Карта: <b>$replace</b>

👤Игроков онлайн: <b>$online</b>/<b>$max</b>",
    'parse_mode'=>'html',
    'reply_markup'=>json_encode(['inline_keyboard'=>[
    [
        ['text'=>"Список игроков",'callback_data'=>"players_hzd"]
    ],
    [
        ['text'=>"⬅️ Назад",'callback_data'=>"kf"]
    ],
    ],'resize_keyboard'=>true])
    ]);
}
}

if($data == "mc"){

# KF-Masters
$server_ip = '185.97.254.214:7444';

# ставим кеш на 1 мин (60 сек)
$cachetime = 25;

if (file_exists(CACHE_DIR . '/'.$server_ip.'.json') && time() - $cachetime < filemtime(CACHE_DIR.'/'.$server_ip.'.json')) {

	$server_info = json_decode(file_get_contents(CACHE_DIR.'/'.$server_ip.'.json'), true);

} else {
	
	$server_info = $API->method("server.get", array("address" => $server_ip));
	file_put_contents(CACHE_DIR.'/'.$server_ip.'.json', json_encode($server_info));
	
}

#Masters
$map = $server_info['result']['map']['name'];
$ip = $server_info['result']['address'];
$online = $server_info['result']['players']['now'];
$max = $server_info['result']['players']['max'];
$status = $server_info['result']['status'];

if($status == '1') {
    $status = '✅ Работает';
}elseif($status == '0'){
    $status = '❌ Не работает';
}

if (preg_match_all("/[A-Z].*/", $map, $matches)){
    $replace = $matches[0][0];

    bot('editMessageText',[
    'chat_id'=>$callbackchatid,
    'message_id'=>$callbackmessageid,
    'text'=>"🧟‍♀️ Сервер KF-Massacre

🌐 IP-Адрес: $ip

💠 Статус сервера: <b>$status</b>

🃏 Карта: <b>$replace</b>

👤Игроков онлайн: <b>$online</b>/<b>$max</b>",
    'parse_mode'=>'html',
    'reply_markup'=>json_encode(['inline_keyboard'=>[
    [
        ['text'=>"Список игроков",'callback_data'=>"players_mc"]
    ],
    [
        ['text'=>"⬅️ Назад",'callback_data'=>"kf"]
    ],
    ],'resize_keyboard'=>true])
    ]);
}
}

?>