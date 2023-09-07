<?php
$proxyAddress = '106.11.226.232:8009';  // Adres serwera proxy
$csvFilePath = 'csv2/czes.csv';
$host = 'https://www.baza-firm.com.pl';

// Wczytanie zawartości pliku CSV do tablicy
$urlArray = file($csvFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$dom = new DOMDocument();
$ch = curl_init();


$csvFileName = 'csv2/img_links.csv';
$csvFile = fopen($csvFileName, 'a');

$csvFileNameZ = 'csv2/zrobione.csv';
$csvFileZrobione = fopen($csvFileNameZ, 'a');

$csvFileNameError = 'csv2/errorlinks.csv';
$csvFileError = fopen($csvFileNameError, 'a');

foreach ($urlArray as $link) {
// Ustawienie opcji cURL dla każdego linku
    curl_setopt($ch, CURLOPT_URL, $link);
    curl_setopt($ch, CURLOPT_PROXY, $proxyAddress);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $html = curl_exec($ch); // Pobranie zawartości strony

    if ($html === false) {
        fputcsv($csvFileError, array($link)); // Zapis do pliku CSV w poprawnym formacie

    } else {
        @$dom->loadHTML($html); // Załadowanie zawartości strony do DOMDocument
        $images = $dom->getElementsByTagName('img');

        foreach ($images as $image) {
            $src = $image->getAttribute('src');
            if (strpos($src, 'includes/adem.php') !== false) {
                $imgList = $host . $src;
                fputcsv($csvFile, array($imgList)); // Zapis do pliku CSV w poprawnym formacie
                fputcsv($csvFileZrobione, array($link)); // Zapis do pliku CSV w poprawnym formacie
            }
        }
    }
    sleep(5);
}

curl_close($ch);

// Zamknięcie pliku
fclose($csvFile);
fclose($csvFileError);
fclose($csvFileZrobione);

