<?php


// Adres URL strony, z której chcesz pobrać linki
$host = 'https://www.baza-firm.com.pl';

    //$url = 'https://www.baza-firm.com.pl/wojewodztwo/podlaskie/strona-'. $i . '/';
    $url = 'https://www.baza-firm.com.pl/wojewodztwo/dolno%C5%9Bl%C4%85skie/strona-2/';
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTMLFile($url);
    libxml_use_internal_errors(false);
    $links = $dom->getElementsByTagName('a');
    $htmlLinks = array();
    foreach ($links as $link) {
        $href = $link->getAttribute('href');
        // Sprawdzenie, czy link kończy się na ".html"
        if (substr($href, -5) === '.html') {
            @$dom->loadHTMLFile($href);
            $images = $dom->getElementsByTagName('img'); // Pobranie wszystkich obrazków
            $imgList = array();
            foreach ($images as $image) {
                $src = $image->getAttribute('src'); // Pobranie atrybutu src
                if (strpos($src, 'includes/adem.php') !== false) {
                    $imgList[] = $host . $src;
                }
            }
        }
    }
    // Otwieranie pliku do zapisu
    $csvFileName = 'csv2/links.csv';
    $csvFile = fopen($csvFileName, 'a');

    // Zapisanie tablicy linków do pliku CSV
    foreach ($imgList as $link) {
        fputcsv($csvFile, array($link));
    }

    // Zamknięcie pliku
    fclose($csvFile);


echo "Linki zostały zapisane do pliku $csvFileName.";