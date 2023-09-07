<?php
/*sprawdzanie listy  proxy
$url = "https://api.proxyscrape.com/v2/?request=displayproxies&protocol=http&timeout=10000&country=all&ssl=all&anonymity=all";
$proxyList = [];

$content = file_get_contents($url);

if ($content !== false) {
    $proxyList = explode("\r\n", $content);
} else {
    die("Nie można pobrać listy proxy.");
}*/


function testProxy($proxy) {
    $url = "https://www.baza-firm.com.pl/includes/adem.php?usr=c2VrcmV0YXJpYXQ=&dmn=ZmFzdHNlcnZpY2UucGw=&mobEml=0";  // Możesz zmienić na inny adres URL do testowania

    $context = stream_context_create([
        "http" => [
            "proxy" => "tcp://" . $proxy,
            "request_fulluri" => true,
            "timeout" => 5,
        ],
    ]);

    $result = file_get_contents($url, false, $context);

    if ($result !== false) {
        echo "Proxy $proxy działa poprawnie.<br>";
    } else {
        echo "Proxy $proxy jest niedostępne.<br>";
    }
}
$proxy = '60.167.176.81:3128';

testProxy($proxy);

/*foreach ($proxyList as $proxy) {
    testProxy($proxy);
}*/