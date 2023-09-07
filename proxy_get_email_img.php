<?php
$csvFileName = 'imgcsv/imglinks.csv';

// Otwarcie pliku do odczytu
$csvFile = fopen($csvFileName, 'r');
$i = 0;

$csvFileNameZ = 'imgcsv/zapisane.csv';
$csvFileZrobione = fopen($csvFileNameZ, 'a');

$csvFileNameError = 'imgcsv/errorimg.csv';
$csvFileError = fopen($csvFileNameError, 'a');

// Konfiguracja proxy (zastąp 'your_proxy_host' i 'your_proxy_port' odpowiednimi danymi)
$proxyContext = stream_context_create([
    'http' => [
        'proxy' => 'tcp://106.75.5.102:8090',
        'request_fulluri' => true,
    ],
    'https' => [
        'proxy' => 'tcp://106.75.5.102:8090',
        'request_fulluri' => true,
    ],
]);

if ($csvFile) {
    while (($line = fgets($csvFile)) !== false) {
        $i++;
        $url = trim($line);

        // Pobierz obrazek za pomocą ustawień proxy
        $imageData = file_get_contents($url, false, $proxyContext);

        if ($imageData === false) {
            fputcsv($csvFileError, array($url));
        } else {
            // Ścieżka do pliku, do którego zostanie zapisany obrazek na twoim serwerze
            $savePath = 'images/email' . $i . '.png';

            // Zapisz obrazek na serwerze
            $result = file_put_contents($savePath, $imageData);

            if ($result !== false) {
                fputcsv($csvFileZrobione, array($url));
            }
        }

    }

    // Zamknięcie pliku
    fclose($csvFile);
    fclose($csvFileError);
    fclose($csvFileZrobione);
} else {
    echo "Nie udało się otworzyć pliku $csvFileName.";
}
?>
