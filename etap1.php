<?php

// Wczytanie zawartości strony
$html = file_get_contents('https://www.baza-firm.com.pl/wojewodztwo/lubelskie/');

// Tworzenie obiektu DOMDocument
$dom = new DOMDocument();
libxml_use_internal_errors(true); // Włącz obsługę błędów XML
$dom->loadHTML($html);

// Inicjalizacja pustej tablicy na unikalne odnośniki
$uniqueLinks = array();

// Pobieranie wszystkich odnośników
$allLinks = $dom->getElementsByTagName('a');
foreach ($allLinks as $link) {
    $href = $link->getAttribute('href');
    // Sprawdzanie warunków
    if (strpos($href, 'https://www.baza-firm.com.pl') === 0 && str_ends_with($href, '.html')) {
        // Sprawdzanie, czy odnośnik jest już w tablicy unikalnych odnośników
        if (!isset($uniqueLinks[$href])) {
            $uniqueLinks[$href] = true; // Dodawanie odnośnika do tablicy unikalnych odnośników
        }
    }
}

// Zapisywanie unikalnych odnośników do pliku CSV
$csvFile = fopen('csv2/links.csv', 'a');
if ($csvFile) {
    fputcsv($csvFile, array('Odnośniki'));

    foreach (array_keys($uniqueLinks) as $uniqueLink) {
        fputcsv($csvFile, array($uniqueLink));
    }

    fclose($csvFile);
    echo 'Unikalne odnośniki zostały zapisane do pliku CSV.';
} else {
    echo 'Nie udało się otworzyć pliku CSV do zapisu.';
}

// Wyczyść błędy XML
libxml_clear_errors();
?>
