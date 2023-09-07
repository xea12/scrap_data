<?php

// Ustawienia proxy
$proxyAddress = '116.130.233.22:3129'; // Adres proxy


$csvFileName = 'csv/podlasie.csv';
$existingLinks = file($csvFileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Utworzenie tablicy asocjacyjnej do przechowywania unikalnych linków
$uniqueLinks = array();
$ch = curl_init();

for ($i = 2; $i < 4; $i++) {
    $url = 'https://www.baza-firm.com.pl/wojewodztwo/podlaskie/strona-' . $i . '/';

    curl_setopt($ch, CURLOPT_URL, $url);  // Adres docelowy
    curl_setopt($ch, CURLOPT_PROXY, $proxyAddress);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  // Zwracaj odpowiedź zamiast jej wyświetlać


    // Wykonanie zapytania cURL
    $response = curl_exec($ch);

    // Obsługa błędów
    if ($response === false) {
        echo 'Błąd cURL: ' . curl_error($ch);
        continue;
    } else {

        // Tworzenie DOMDocument z odpowiedzi
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($response);
        libxml_use_internal_errors(false);

        // Znalezienie wszystkich linków
        $links = $dom->getElementsByTagName('a');
        print_r($links);
        // Przechowywanie linków spełniających warunki
        $htmlLinks = array();

        /*    foreach ($links as $link) {
                $href = $link->getAttribute('href');

                // Warunek: Link zaczyna się od "https://www.baza-firm.com.pl" i kończy się na ".html"
                if (strpos($href, 'https://www.baza-firm.com.pl') === 0 && str_ends_with($href, '.html')) {
                    echo $href;
                    $htmlLinks[] = $href;
                }
            }*/

        /*    // Dodawanie nowych, unikalnych linków do tablicy asocjacyjnej
            foreach ($htmlLinks as $link) {
                if (!isset($uniqueLinks[$link])) {
                    $uniqueLinks[$link] = true;
                    // Dodawanie do tablicy z istniejącymi linkami
                    if (!in_array($link, $existingLinks)) {
                        $existingLinks[] = $link;
                    }
                }
            }*/
    }
    // Zamknięcie sesji cURL
    curl_close($ch);
}

/*// Otwarcie pliku do zapisu
$csvFile = fopen($csvFileName, 'a');

// Zapisanie linków z tablicy do pliku CSV
foreach ($existingLinks as $link) {
    fwrite($csvFile, $link . PHP_EOL);
}

// Zamknięcie pliku
fclose($csvFile);

echo "Linki zostały dodane do pliku $csvFileName bez duplikatów.";*/

?>
