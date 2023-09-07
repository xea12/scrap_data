

<?php
$csvFileName = 'imgcsv/imglinks.csv';

// Otwarcie pliku do odczytu
$csvFile = fopen($csvFileName, 'r');
$i = 0;

$csvFileNameZ = 'imgcsv/zapisane.csv';
$csvFileZrobione = fopen($csvFileNameZ, 'a');

$csvFileNameError = 'imgcsv/errorimg.csv';
$csvFileError = fopen($csvFileNameError, 'a');

if ($csvFile) {
    while (($line = fgets($csvFile)) !== false) {
        $i++;
        $url = trim($line);
        $imageData = file_get_contents($url);

        if ($imageData === false) {
            // Obsłuż błąd, jeśli pobranie nie powiodło się
            echo 'Nie można pobrać obrazka.';
        } else {
            // Ścieżka do pliku, do którego zostanie zapisany obrazek na twoim serwerze
            $savePath = 'images/email'. $i . '.png';

            // Zapisz obrazek na serwerze
            $result = file_put_contents($savePath, $imageData);

            if ($result !== false) {

                fputcsv($csvFileZrobione, array($url));
            } else {
                fputcsv($csvFileError, array($url));
            }
        }
        sleep(1);
    }

    // Zamknięcie pliku
    fclose($csvFile);
    fclose($csvFileError);
    fclose($csvFileZrobione);
} else {
    echo "Nie udało się otworzyć pliku $csvFileName.";
}
?>