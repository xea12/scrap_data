<?php
use thiagoalessio\TesseractOCR\TesseractOCR;
require_once 'vendor/autoload.php';
ini_set('max_execution_time', 3660);
// Lista URL-ów z pliku CSV
$csvFilePath = 'csv/podlsasie100s.csv';

// Wczytanie zawartości pliku CSV do zmiennej
$csvContent = file_get_contents($csvFilePath);

// Konwertuj listę URL-ów na tablicę
$urlArray = explode("\n", trim($csvContent));
$i = 1;
$emails = array();
foreach ($urlArray as $imageUrl) {
    $i++;
    $imageUrl = trim($imageUrl);

    // Lokalna ścieżka, gdzie chcesz zapisać obrazek
    $localPath = "images/emailimg".$i.".png";

    // Pobranie danych obrazka
    $imageData = file_get_contents($imageUrl);

    if ($imageData !== false) {
        // Zapisanie danych do pliku na dysku
        $result = file_put_contents($localPath, $imageData);

        if ($result !== false) {
            $tesseract = new TesseractOCR($localPath);

            $detectedText = $tesseract->run();

            $emails[] = $detectedText;
        } else {
            echo "Wystąpił problem podczas zapisywania obrazka na dysku.\n";
        }
    } else {
        echo "Nie można pobrać danych obrazka dla URL $imageUrl.\n";
    }
}

// Otwieranie pliku do zapisu
$csvFileName = 'csv/emails.csv';
$csvFile = fopen($csvFileName, 'a');

// Zapisanie tablicy linków do pliku CSV
foreach ($emails as $email) {
    fputcsv($csvFile, array($email));
}

// Zamknięcie pliku
fclose($csvFile);
?>
