<?php
function vypocetSlevyNaDani($pocetDeti, $pocetZTPDeti)
{
    $slevaNaDani = 0;

    // Hodnoty slev pro první, druhé a třetí a každé další dítě
    $slevy = [1267, 1860, 2320];

    // Výpočet slevy pro všechny děti
    for ($i = 0; $i < $pocetDeti; $i++) {
        // ZTP děti se počítají od konce
        if ($i >= ($pocetDeti - $pocetZTPDeti)) {
            // Dítě je ZTP
            $slevaNaDani += $slevy[min($i, 2)] * 2;
        } else {
            // Dítě není ZTP
            $slevaNaDani += $slevy[min($i, 2)];
        }
    }

    return $slevaNaDani;
}

// Příklad použití: 7 dětí, z toho 4 jsou ZTP
$pocetDeti = 4;
$pocetZTPDeti = 2;
echo "Celková sleva na dani: " . vypocetSlevyNaDani($pocetDeti, $pocetZTPDeti) . " Kč";
