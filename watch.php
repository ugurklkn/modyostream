<?php

if (isset($_GET['video_id']) && !empty($_GET['video_id'])){
    $video_id = $_GET['video_id'];
    $url = "https://1x-bet516351.world/cinema";
    $post = [
        "AppId" => 3,
        "AppVer" => 1064,
        "Language" => "en",
        "Token" => "",
        "VideoId" => strval($video_id)
    ];
    $post = json_encode($post,true);

    $headers = [
        'Accept: */*',
        'Accept-Language: tr-TR,tr;q=0.9',
        'Host: 1x-bet516351.world',
        'Origin: https://1x-bet516351.world',
        'Referer: https://1x-bet516351.world/getZone/liveplayer/v2/vpc/index.html?id=3d3c0834-b7cb-b14d-9ccf-2634f2f4d180',
        'User-Agent: '.$_SERVER['HTTP_USER_AGENT'],
        'Content-Type: application/json',
        'Sec-Fetch-Mode: cors',
        'Sec-Fetch-Dest: empty',
        'Sec-Fetch-Site: same-origin',
        'TE: trailers',
        'Connection: keep-alive'
       
    ];

    $ch = curl_init();
    $arr = [
        curl_setopt($ch, CURLOPT_PROXYPORT, '8080');
        curl_setopt($ch, CURLOPT_PROXYTYPE, 'HTTP');
        curl_setopt($ch, CURLOPT_PROXY,'212.174.242.102');
        curl_setopt($ch, CURLOPT_PROXYUSERPWD,'');
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_USERAGENT => $_SERVER["HTTP_USER_AGENT"],
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => $post
    ];

    curl_setopt_array($ch,$arr);

    $source = curl_exec($ch);
    curl_close($ch);




    preg_match('@"URL":"(.*?)"@',$source,$matches);
    $stream = str_replace("\\","",$matches[1]);
    
    $bol = explode('/',$stream);
    
    $stream = "https://kralnaber.site/edge1/".$bol[3].'/'.$bol[4].'/'.$bol[5].'/'.$bol[6];
}else{
    echo "Invalid Request";
}
?>
<?=$stream?>