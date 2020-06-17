<?php
ob_start();
define('API_KEY','907556966:AAHElD-vmvQMg4ZoleqNQy0APPWmnyA407E');
//tokenni yozing
$admin = "630751054";
function fsize($size,$round=2)
{
$sizes=array(' Bytes',' Kb',' Mb',' Gb',' Tb');
$total=count($sizes)-1;
for($i=0;$size>1024 && $i<$total;$i++){
$size/=1024;
}
return round($size,$round).$sizes[$i];
}
function del($nomi){
   array_map('unlink', glob("$nomi"));
   }

function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$reply= $message->reply_to_message->text;

$mid = $message->message_id;
$chat_id = $message->chat->id;
$text1 = $message->text;
$user_id = $message->from->id;
$first_name=$message->from->first_name;
$last_name=$message->from->last_name;
$username=$message->from->username;
$sreply = $message->reply_to_message->text;
$ent = $message->entities[0]->type;
$reply_menu = json_encode([
'resize_keyboard'=>true,
'force_reply' => true,
'selective' => true
]);
if($text1=="/start"){
bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"Bu bot juda foydali.
Botni kanalingizga admin qiling.
Musica yuboring.Yuborgan musicangizga kanalingiz usernamesini qo'yadi va musica ma'lumotlarini tagiga yozib beradi va yana bir funksiya musicangizdan 30 soniya qirqibham beradi.Barchasi avtomatlashtrilgan.",
    'parse_mode'=>'markdown',
    'reply_markup'=>json_encode([
      'inline_keyboard'=>[
        [['text'=>"Bog'lanish",'url'=>'t.me/tilon']],
]
    ])
  ]);
}

$chm = $update->channel_post;
$chuser = $chm->chat->username;
$chtext = $chm->text;
$title = $chm->chat->title;
$chma = $chm->audio;
$doc=$chm->audio;
$doc_id = $chma->file_id;
$message_ch_mid = $chm->message_id;
$message_ch_chid = $chm->chat->id;
 if($chma){
$url = json_decode(file_get_contents('https://api.telegram.org/bot'.API_KEY.'/getFile?file_id='.$doc_id),true);
$path=$url['result']['file_path'];
$file = 'https://api.telegram.org/file/bot'.API_KEY.'/'.$path;
$ftitle = $chma->title;
$fname = $chma->performer;
$type = strtolower(strrchr($file,'.')); 
$typeee=str_replace('dodasi.com','@'.$chuser,$ftitle);
file_put_contents($doc_id.".mp3",file_get_contents($file));
$xajm = fsize(filesize($doc_id.".mp3"));
bot('deletemessage',[ 'chat_id'=>$message_ch_chid, 'message_id'=>$message_ch_mid ]);
$chid = $message_ch->chat->id;
$size = $chma->file_size;
$dur12 = $chma->duration;
include("getid3/getid3.php");
$getID3 = new getID3;
$filer = $getID3->analyze($doc_id.".mp3");
$durm = $filer['playtime_string'];
require 'phpmp3.php';
$mp3 = new PHPMP3($doc_id.".mp3");
$mp3_1 = $mp3->extract(15,45);
$mp3_1->save($doc_id.'.ogg');
$ahajmi = $getID3->analyze($doc_id.".ogg");
$voice = bot('sendVoice',[
          'chat_id'=>$message_ch_chid,
'voice'=>new CURLFile($doc_id.".ogg"),
'duration'=>'30',
      'caption'=>$fname."-".$typeee."\n👇Musicani to'liq holatda tinglang👇\n\n@".$chuser." kanali uchun maxsus",
          ]);

$buton = "⤴️Dostlarga ulashish";
$cap = "@$chuser kanali uchun maxsus";
if(strpos($voice,"Bad Request: failed to get HTTP URL content")!==false){
$aydi=$message_ch_mid+2;
}else{
$aydi=$message_ch_mid+2;
}
bot('sendAudio',[
          'chat_id'=>$message_ch_chid,
          'audio'=>new CURLFile($doc_id.".mp3"),
        'title'=>$fname."-".$typeee,
        'performer'=>"@".$chuser,
          'thumb'=>$fileid,
      'caption'=>$fname."-".$typeee."\n 💾|" .$xajm."  ⏰|" .$durm."\n\n".$cap,
'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                [['text'=>"$buton", "url"=>"https://t.me/share/url?url=https://telegram.me/$chuser/$aydi"]],
            ]
        ])
          ]);
del($doc_id.".mp3");
del($doc_id.".ogg");
}
ini_set('memory_limit','4096');
