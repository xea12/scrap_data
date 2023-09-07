<?php

$csvFileName = 'csv/podlasie.csv';
$existingLinks = file($csvFileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Utworzenie tablicy asocjacyjnej do przechowywania unikalnych linków
$uniqueLinks = array();

for ($i = 1; $i < 4; $i++) {
    $url = 'https://www.bazafirm.net/index.php?cnt=company.search&searchkey=&district_id=-1&cpg=' . $i ;


    // Tworzenie DOMDocument z odpowiedzi
    $dom = new DOMDocument();
    $htmlContent = file_get_contents($url);
    $dom->loadHTML($htmlContent);

    // Znalezienie wszystkich linków
    $links = $dom->getElementsByTagName('a');
    // Przechowywanie linków spełniających warunki
    $htmlLinks = array();

    foreach ($links as $link) {
        $href = $link->getAttribute('href');

        // Warunek: Link zaczyna się od "https://www.baza-firm.com.pl" i kończy się na ".html"
        if (strpos($href, 'index.php?cnt') === 0) {
            echo $href;
            $htmlLinks[] = $href;
        }
    }

    // Dodawanie nowych, unikalnych linków do tablicy asocjacyjnej
    foreach ($htmlLinks as $link) {
        if (!isset($uniqueLinks[$link])) {
            $uniqueLinks[$link] = true;
            // Dodawanie do tablicy z istniejącymi linkami
            if (!in_array($link, $existingLinks)) {
                $existingLinks[] = $link;
            }
        }
    }

}

// Otwarcie pliku do zapisu
$csvFile = fopen($csvFileName, 'a');

// Zapisanie linków z tablicy do pliku CSV
foreach ($existingLinks as $link) {
    fwrite($csvFile, $link . PHP_EOL);
}

// Zamknięcie pliku
fclose($csvFile);

echo "Linki zostały dodane do pliku $csvFileName bez duplikatów.";

?>
