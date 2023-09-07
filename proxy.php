<?php




$proxyAddress = '106.75.5.102:80';  // Adres serwera proxy


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.baza-firm.com.pl/salony-samochodowe/lublin/nazaruk-service-sp-z-oo/pl/24682.html');  // Adres docelowy
curl_setopt($ch, CURLOPT_PROXY, $proxyAddress);


curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  // Zwracaj odpowiedź zamiast jej wyświetlać
$imageData = curl_exec($ch);

if ($imageData === false) {
    echo "Błąd pobierania obrazka: " . curl_error($ch);
} else {
    print_r($imageData);
/*    $imagePath = 'downloaded_image2.jpg';  // Ścieżka, gdzie chcesz zapisać obrazek
    file_put_contents($imagePath, $imageData);
    echo "Obrazek został pobrany i zapisany jako $imagePath";*/
}

curl_close($ch);


/* sprawdza czy proxy dobrze działa
$url = "https://api.proxyscrape.com/v2/?request=displayproxies&protocol=http&timeout=10000&country=all&ssl=all&anonymity=all";
$proxyList = [];

$content = file_get_contents($url);

if ($content !== false) {
    $proxyList = explode("\r\n", $content);
} else {
    die("Nie można pobrać listy proxy.");
}


function testProxy($proxy) {
    $url = "https://www.baza-firm.com.pl/includes/adem.php?usr=bWFya2V0LXN5c3RlbQ==&dmn=d3AucGw=&mobEml=0";  // Możesz zmienić na inny adres URL do testowania

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

foreach ($proxyList as $proxy) {
    testProxy($proxy);
}

*/




?>



