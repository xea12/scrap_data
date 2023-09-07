<?php
// Wczytanie zawartości pliku CSV do tablicy
$csvFileName = 'csv2/links.csv';
$csvContent = file($csvFileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Usunięcie duplikatów
$uniqueCsvContent = array_unique($csvContent);

// Otwarcie pliku do zapisu
$csvFile = fopen($csvFileName, 'w');

// Zapisanie unikalnych wartości z powrotem do pliku
foreach ($uniqueCsvContent as $line) {
    fwrite($csvFile, $line . PHP_EOL);
}

// Zamknięcie pliku
fclose($csvFile);

echo "Duplikaty zostały usunięte z pliku $csvFileName.";
?>