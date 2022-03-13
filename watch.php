<?php
header('Access-Control-Allow-Origin: *');

date_default_timezone_set('Europe/Istanbul');
if (isset($_GET['url']) && !empty($_GET['url'])){
    $url = $_GET['url'];

    $url = "https://assia4.com/live/".$url.'/';

    $headers = [
        'Accept: */*',
        'Accept-Language: tr-TR,tr;q=0.9',
        'Host: assia4.com',
        'Referer: https://assia4.com/',
        'Origin: https://assia4.com/',
        'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.80 Safari/537.36'
    ];

    $ch = curl_init($url);
    /* set the user agent - might help, doesn't hurt */
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);


	/* try to follow redirects */
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

	/* timeout after the specified number of seconds. assuming that this script runs
	on a server, 20 seconds should be plenty of time to verify a valid URL.  */
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
	curl_setopt($ch, CURLOPT_TIMEOUT, 20);
	
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

curl_setopt($ch, CURLOPT_VERBOSE, true);

/* don't download the page, just the header (much faster in this case) */
curl_setopt($ch, CURLOPT_NOBODY, false);
curl_setopt($ch, CURLOPT_HEADER, true);

   
    $source = curl_exec($ch);
    curl_close($ch);


    preg_match('@source: \'(.*?)\'@',$source,$matches);
    $stream = $matches[1];

    //IP DEĞİŞİR İSE BURADAN DEĞİŞTİREBİLİRSİNİZ
    $ip = "https://6assia.com/";

    $explode = explode('/',$stream);
    $stream = $ip.$explode[3].'/'.$explode[4];

}else{
    echo "Invalid Request";
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://vjs.zencdn.net/7.17.0/video-js.css" rel="stylesheet" />
</head>
<body>
    <video id="my_video_1" class="video-js vjs-default-skin" controls preload="auto" width="1340" height="600"
           data-setup='{}'>
        <source src="<?=$stream?>" type='application/x-mpegURL'>
    </video>
<script src="https://vjs.zencdn.net/7.17.0/video.min.js"></script>
    <script>
        var player = videojs('my_video_1');
      videojs.xhr({
        url: "<?=$stream?>",
        headers: {
          'X-Token': 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJuYW1lIjoiZGVtb3VzZXIifQ.Et6cTa3_AQsMEj56URS6cvSO_-xDezUdId8y6RdlIa8',
          'Host': '6assia.com',
          'Referrer': 'https://assia4.com/',
          'Origin': 'https://assia4.com'
        }
      }, (err, response, body) => {
        if(err) throw err;
        if( response.statusCode === 200 ) {
          player.src(body)
        } else {
          console.error(response)
        }
      })
    </script>
    
</body>
</html>
