<?php
$proxyAddress = '106.11.226.232:8009';
$csvFilePath = 'csv2/links.csv';
$errorFilePath = 'csv2/errors.csv';
$lostSite = [102, 110, 188, 194, 200, 201, 223, 230, 244, 276, 298, 339, 379, 468];
$siteWithError = array();

foreach ($lostSite as $i) {
//for ($i = 400; $i < 481; $i++) {
    $url = 'https://www.baza-firm.com.pl/wojewodztwo/lubelskie/strona-' . $i . '/';

    // Inicjalizacja uchwytu cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_PROXY, $proxyAddress);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Zwracaj odpowiedź zamiast jej wyświetlać

    // Ustawienie dłuższego limitu czasu oczekiwania (np. 120 sekund)
    curl_setopt($ch, CURLOPT_TIMEOUT, 120);

    // Przechwytywanie wyjątków cURL
    try {
        // Wykonanie zapytania cURL
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new Exception('Błąd cURL: ' . curl_error($ch));
        }
    } catch (Exception $e) {
        // Zapisywanie informacji o błędzie i numerze strony do pliku CSV
        $errorInfo = array($url, $e->getMessage());
        $errorFile = fopen($errorFilePath, 'a');
        if ($errorFile) {
            $siteWithError[] = $i;
            fputcsv($errorFile, $errorInfo);
            fclose($errorFile);
        } else {
            echo 'Nie udało się otworzyć pliku błędów CSV do zapisu.';
        }
        continue; // Przejdź do kolejnej iteracji pętli, omijając stronę
    }

    // Zakończenie sesji cURL
    curl_close($ch);

    // Jeśli nie wystąpił błąd cURL, kontynuuj przetwarzanie strony
    if (isset($response)) {
        //var_dump($response);
        // Tworzenie obiektu DOMDocument
        $dom = new DOMDocument();
        libxml_use_internal_errors(true); // Włącz obsługę błędów XML
        $dom->loadHTML($response);

        // Pobieranie wszystkich odnośników
        $allLinks = $dom->getElementsByTagName('a');

        // Inicjalizacja zbioru na unikalne odnośniki
        $uniqueLinks = array();

        // Otwieranie lub tworzenie pliku CSV
        $csvFile = fopen($csvFilePath, 'a');
        if (!$csvFile) {
            echo 'Nie udało się otworzyć pliku CSV do zapisu.';
            exit;
        }

        foreach ($allLinks as $link) {
            $href = $link->getAttribute('href');
            // Sprawdzanie warunków
            if (strpos($href, 'https://www.baza-firm.com.pl') === 0 && str_ends_with($href, '.html')) {
                // Sprawdzanie, czy odnośnik jest już w zbiorze unikalnych odnośników
                if (!isset($uniqueLinks[$href])) {
                    // Zapisywanie unikalnego odnośnika do pliku CSV
                    fputcsv($csvFile, array($href));
                    // Dodawanie odnośnika do zbioru unikalnych odnośników
                    $uniqueLinks[$href] = true;
                }
            }
        }

        // Zamykanie pliku CSV
        fclose($csvFile);

        // Wyczyść błędy XML
        libxml_clear_errors();
    }

    // Przerwa na kilka sekund (np. 5 sekund)
    sleep(10);
}
$string = "[" . implode(', ', $siteWithError) . "]";
echo $string;
echo 'Operacja została zakończona.';
?>
