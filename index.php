<?php

class StreamBot{
    public $url = "http://assia2.com/table.xml";
    public $curl;
    public $curl_options;
    public $curl_headers;
    public $token;
    protected $source;

    public function __construct()
    {
        $this->curl = curl_init();
        $this->setHeaders();
        $this->setOptions();
    }

    public function setHeaders()
    {
        $this->curl_headers = [
            'Accept: */*',
            'Accept-Language: tr-TR,tr;q=0.9',
            'Host: streamsport365.com',
            'Referer: https://streamsport365.com/',
            'Origin: https://streamsport365.com',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.99 Safari/537.36'
        ];
    }

    public function setOptions($url = false,$post = false,$data = [])
    {
        $this->curl_options = [
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => $_SERVER["HTTP_USER_AGENT"],
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => $this->curl_headers,
            CURLOPT_POST => $post
        ];

        if($url != false){
            $this->curl_options[CURLOPT_URL] = $url;
        }

        curl_setopt_array($this->curl,$this->curl_options);
    }

    public function get()
    {

        $this->source = curl_exec($this->curl);

        curl_close($this->curl);
    }

    public function getIndex()
    {
        $this->get();

        return $this->source;
    }

    public function getToken($url)
    {
        $url = $url;
        $post = true;
        $this->setOptions($url,$post);

        $this->get();
        $data = json_decode($this->source,true);

        $this->token = $data['connectionToken'];

        return $this->token;
    }
}
$stream = new StreamBot();
$source = $stream->getIndex();
$xml = simplexml_load_string($source, "SimpleXMLElement", LIBXML_NOCDATA);
$json = json_encode($xml);
$array = json_decode($json,TRUE)["event"];
//print_r($array);
//$token =  $stream->getToken(); //Socket Bağlantısı için gerekli tokeni aldık.

?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maç Yayın</title>
</head>
<body>
<table cellpadding="5" cellspacing="5" border="2">
    <thead>
    <tr>
        <th>Spor</th>
        <th>Lig</th>
        <th>Maç Adı</th>
        <th>Başlama Tarihi</th>
        <th>Başlama Saati</th>
        <th>İşlem</th>
    </tr>
    </thead>
    <tbody id="in">
        <?php foreach ($array as $item): ?>
        <?php
            $url = explode('/',$item['urls']);
            $url = $url[4];

            $startTime = explode(':',$item['startTime']);
            $startTime = $startTime[0].":".$startTime[1];
        ?>
            <tr>
                <td><?=$item['sport']?></td>
                <td><?=$item['league']?></td>
                <td><?=$item['name']?></td>
                <td><?=$item['startDate']?></td>
                <td><?=$startTime?></td>
                <td><a style="padding: 2px; border: 1px solid #ddd; border-radius: 10px; background-color: brown; color:white;" href="watch.php?url=<?=$url?>">İzle</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
    <tr>
        <th>Spor</th>
        <th>Lig</th>
        <th>Maç Adı</th>
        <th>Başlama Tarihi</th>
        <th>Başlama Saati</th>
        <th>İşlem</th>
    </tr>
    </tfoot>
</table>

<script
    src="https://code.jquery.com/jquery-3.6.0.js"
    integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
    crossorigin="anonymous"></script>
</body>
</html>
