<?php

/*
Prosze napisać prosty program, który będzie pomagał grupie znajomych umówić się na konkretną godzinę.

Każda z osób wywoła nasz skrypt z parametrami oznaczającymi jego imię i preferowaną godzinę, np.
http://serwer/Umow.php?kto=KamilS&godzina=12:00

Strona, która się otworzy powinna pokazywać jak zagłosowali inni koledzy, np:

16:00 - 3 osoby (Michał, Arek, Kasia)
16:30 - 2 osoby (KamilC, Łukasz)
12:00 - 1 osoba (kamilS)

Mile widziane jest grupowanie odpowiedzi i sortowanie ich.
Wejście na stronę drugi raz przez tą samą osobę ma zmienić jego głos a nie dodać nowy.

Do przechowywania danych wystarczy prosty plik tekstowy na serwerze, proszę wybrać najprostszą dla siebie metodę.

Z powodu ogranicznonego czasu na wykonanie nie jest wymagane dopracowanie wyglądu strony, oraz wprowadzanie javascript.
*/

// tworzy plik jeśli ten nie istnieje
if (!file_exists('results.json')) {
    touch('results.json');
}

// dodaje nowy rekord o ile podano wartości 'kto' i 'godzina'
if (!empty($_GET['kto']) && !empty($_GET['godzina'])) {
    $who = $_GET['kto'];
    $time = $_GET['godzina'];

    // wczytanie danych z pliku
    $results = json_decode(file_get_contents('results.json'), true);

    // dodanie / nadpisanie rekordu
    $results[$who] = $time;
    
    // zapisanie wszystkich danych do pliku
    file_put_contents('results.json', json_encode($results));
}

// wczytanie danych z pliku
$results = json_decode(file_get_contents('results.json'), true);

// grupuje osoby wg godzin
$groupedResults = [];
foreach ($results as $name => $time) {
    $groupedResults[$time][] = $name;
}

// sortuje wpisy wg ilości osób
array_multisort(array_map('count', $groupedResults), SORT_DESC, $groupedResults);

?>

<html>
    <body>
        <div style="margin-top: 20px; margin-left: 10px;">
            <?php
                // wypisywanie rekordów na ekran
                foreach ($groupedResults as $groupedTime => $names) {
                    $count = count($names);
                    $peopleText = ($count > 1) ? ' osoby (' : ' osoba (';
                    $text = $groupedTime . ' - ' . $count . $peopleText;
                    foreach ($names as $name) {
                        $text .= $name . ', ';
                    }
                    $text = substr($text, 0, -2);
                    $text .= ')' . "<br>";
                    echo "<p style='margin: 5px'>" . $text . "</p>";
                }
            ?>
        </div>
    </body>
</html>
