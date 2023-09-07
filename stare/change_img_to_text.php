<?php
use thiagoalessio\TesseractOCR\TesseractOCR;
require_once 'vendor/autoload.php';
// URL obrazka

$csvFilePath = 'csv/podlsasie100s.csv';
$i = 1;
// Wczytanie zawartości pliku CSV do zmiennej
$csvContent = file_get_contents($csvFilePath);
$urlArray = explode("\n", trim($csvContent));
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
    }
}