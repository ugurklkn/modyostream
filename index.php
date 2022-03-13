<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class StreamBot{
    public $url = "https://part.sport1xbet.com/PartLive/GetAllLineVideo?lng=en";
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
            'Host: part.sport1xbet.com',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.99 Safari/537.36'
        ];
    }

    public function setOptions($url = false,$post = false,$data = [])
    {
        $this->curl_options = [
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => $_SERVER["HTTP_USER_AGENT"],
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_HTTPHEADER => $this->curl_headers,
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
$array = json_decode($source,true);

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
        <th>Takım 1</th>
        <th>Takım 2</th>
        <th>Başlama Tarihi</th>
        <th>İşlem</th>
    </tr>
    </thead>
    <tbody id="in">
        <?php foreach ($array as $item): ?>
            <tr>
                <td><?=$item['Sport']?></td>
                <td><?=$item['Liga']?></td>
                <td><?=$item['Home']?></td>
                <td><?=$item['Away']?></td>
                <td><?=date('H:i:s', intval($item['Start']));?></td>
                <td><a style="padding: 2px; border: 1px solid #ddd; border-radius: 10px; background-color: brown; color:white;" href="watch.php?video_id=<?=$item['VI']?>">İzle</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
    <tr>
        <th>Spor</th>
        <th>Lig</th>
        <th>Takım 1</th>
        <th>Takım 2</th>
        <th>Başlama Tarihi</th>
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
