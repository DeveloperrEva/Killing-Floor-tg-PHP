<?php


include_once __DIR__."/../functions/bot.php";
include __DIR__."/../config/variables.php";
include __DIR__."/../config/config.php";

///////////==[DB Connection]==///////////
$conn = mysqli_connect($config['db']['hostname'],$config['db']['username'],$config['db']['password'],$config['db']['database']);

if(!$conn){
    bot('sendmessage',[
        'chat_id'=>$config['adminID'],
        'text'=>"<b>🛑 Плохое подключение к БД!
        
        ".json_encode($config['db'])."</b>",
        'parse_mode'=>'html'
        
    ]);

    logsummary("<b>🛑 Плохое подключение к БД!\n\n".json_encode($config['db'])."</b>");
}

////////////////////////////////////////////

function fetchUser($userID){
    global $conn;
    $dataf = mysqli_query($conn,"SELECT * FROM users WHERE userid='$userID'");

    if(mysqli_num_rows($dataf) == 0){
        return False;
    }

    $userData = $dataf->fetch_assoc();
    
    return $userData;

}

function isBanned($userID){
    global $chat_id;
    global $message_id;
    $userData = fetchUser($userID);

    if($userData['is_banned'] == "True"){
        bot('sendmessage',[
            'chat_id'=>$chat_id,
            'text'=>"<b>Хехе! Ты в бане</b>",
        'parse_mode'=>'html',
        'reply_to_message_id'=> $message_id
        ]);
        return True;
    }else{
        return False;
    }

}

function access($userID){
    global $chat_id;
    global $message_id;
    $userData = fetchUser($userID);

    if($userData['access'] == "True"){
        
        return True;
    }else{
        return False;
    }

}

function isMuted($userID){
    global $chat_id;
    global $message_id;
    global $conn;
    $userData = fetchUser($userID);

    if($userData['is_muted'] == "True"){
        $muted_for = $userData['mute_timer']-time();

        if($muted_for >= 0){
        bot('sendmessage',[
            'chat_id'=>$chat_id,
            'text'=>"<b>🛑 Ты в муте!
            
Try Again after <code>".date("F j, Y, g:i a",$userData['mute_timer'])."</code></b>",
        'parse_mode'=>'html',
        'reply_to_message_id'=> $message_id
        ]);
        return True;
        }else{
            mysqli_query($conn,"UPDATE users SET is_muted = 'False',mute_timer = '0' WHERE userid = '$userID'");
            return False;
        }
    }else{
        return False;
    }

}

function addUser($userID){
    global $conn;
    $userData = fetchUser($userID);

    if(!$userData){
        $addtodb = mysqli_query($conn,"INSERT INTO users (userid,username,registered_on,is_banned,is_muted,mute_timer,city) VALUES ('$userID','$username','".time()."','False','False','0','')");
        return True;
    }else{
        return False;
    }

}

function delUser($userID){
    global $conn;
    $userData = fetchUser($userID);

    if(!$userData){
        $addtodb = mysqli_query($conn,"DELETE FROM users WHERE userid = '$userID'");
        return True;
    }else{
        return False;
    }

}

function muteUser($userID,$time){
    global $conn;
    $userData = fetchUser($userID);

    if(!$userData){
        return "Uhmm, This user isn't in my db!";
    }else{
        $muteuser = mysqli_query($conn,"UPDATE users SET is_muted = 'True',mute_timer = '$time' WHERE userid = '$userID'");
        logsummary("<b>🛑 [LOG] Замучен $userID</b>");
        return "Успешно замучен <code>$userID</code> до <code>".date("F j, Y, g:i a",$time)."</code>";
    }

}

function unmuteUser($userID){
    global $conn;
    $userData = fetchUser($userID);

    if(!$userData){
        return "Uhmm, This user isn't in my db!";
    }else{
        $muteuser = mysqli_query($conn,"UPDATE users SET is_muted = 'False',mute_timer = '0' WHERE userid = '$userID'");
        logsummary("<b>🛑 [LOG] Размучен $userID</b>");
        return "Успешно размучен $userID";
    }

}

function banUser($userID){
    global $conn;
    $userData = fetchUser($userID);

    if(!$userData){
        return "Uhmm, This user isn't in my db!";
    }else{
        $muteuser = mysqli_query($conn,"UPDATE users SET is_banned = 'True' WHERE userid = '$userID'");
        
        return "Успешно забанен <code>$userID</code>";
    }

}

function unbanUser($userID){
    global $conn;
    $userData = fetchUser($userID);

    if(!$userData){
        return "Этого пользователя нет в БД!";
    }else{
        $muteuser = mysqli_query($conn,"UPDATE users SET is_banned = 'False' WHERE userid = '$userID'");
        
        logsummary("<b>🛑 [LOG] Разблокирован $userID</b>");

        return "Успешно разблокирован <code>$userID</code>";

        
    }

}

function fetchMutelist(){
    global $conn;

    $data = mysqli_query($conn,"SELECT userid FROM users WHERE is_muted = 'True'");
    if(mysqli_num_rows($data) == 0){
        return False;
    }

    $data = $data->fetch_assoc();
    return $data;
}

function fetchMuteTimer($userID){
    global $conn;

    $data = mysqli_query($conn,"SELECT mute_timer FROM users WHERE userid = '$userID'");
    if(mysqli_num_rows($data) == 0){
        return False;
    }

    $data = $data->fetch_assoc();
    return $data;
}

function fetchBanlist(){
    global $conn;

    $data = mysqli_query($conn,"SELECT userid FROM users WHERE is_banned = 'True'");
    if(mysqli_num_rows($data) == 0){
        return False;
    }

    $data = $data->fetch_assoc();
    return $data;
}


function totalBanned(){
    global $conn;

    $data = mysqli_query($conn,"SELECT * FROM users WHERE (is_banned = 'True')");
    return mysqli_num_rows($data);

}

function totalMuted(){
    global $conn;

    $data = mysqli_query($conn,"SELECT * FROM users WHERE (is_muted = 'True')");
    return mysqli_num_rows($data);

}


///////===[ANTI-SPAM]===///////

function existsLastChecked($userID){
    global $conn;
    $dataf = mysqli_query($conn,"SELECT * FROM antispam WHERE userid='$userID'");

    if(mysqli_num_rows($dataf) == 0){
        return False;
    }

    $userData = $dataf->fetch_assoc();
    
    return $userData['last_checked_on'];

}

function antispamCheck($userID){
    global $conn;
    global $config;

    $antiSpamGey = existsLastChecked($userID);
    
    if($userID == $config['adminID']){
        return False;
    }
    if($userID == $config['donateID']){
        return False;
    }
    if($antiSpamGey == False){
        $addtodb = mysqli_query($conn,"INSERT INTO antispam (userid,last_checked_on) VALUES ('$userID','".time()."')");
        return False;
    }else{
        if(time() - $antiSpamGey > $config['anti_spam_timer']){
            $addtodb = mysqli_query($conn,"UPDATE antispam set last_checked_on = '".time()."' WHERE userid = '$userID'");
            return False;
        }else{
            return $config['anti_spam_timer'] - (time() - $antiSpamGey);
        }
        
    }

}

function textlog($conn, $userid, $text){

	if($userid == '')
		return false;
	$t = "INSERT INTO textlog (chat_id, text) VALUES ('%s', '%s')";
	$query = sprintf($t, mysqli_real_escape_string($conn, $userid),
							mysqli_real_escape_string($conn, $text));
	$result = mysqli_query($conn, $query);

	if(!$result)
		die(mysqli_error($conn));
	return true;				
}


function users_all($conn){
	$query = "SELECT * FROM users";
	$result = mysqli_query($conn, $query);
	if(!$result)
		die(mysqli_error($conn));
	$n = mysqli_num_rows($result);
	$users_all = array();
	for ($i = 0; $i <$n; $i++){
		$row = mysqli_fetch_assoc($result);
		$users_all[] = $row;
	}
	return $users_all;
}




?>