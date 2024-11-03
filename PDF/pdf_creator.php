<?php
if (!$_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "You have to fill the form first!";
}

require_once __DIR__ . '/../vendor/autoload.php';

// PDF format
$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => "A4-P",
    'margin_left' => 10,
    'margin_right' => 10,
    'margin_top' => 10,
    'margin_bottom' => 10
]);

// CSS import
$stylesheet = file_get_contents("../css/pdf.css");
$mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);

// Data from form
$grossSalary = floatval($_POST['gross_salary']);
$childrenCount = isset($_POST['children']) ? intval($_POST['children']) : 0;
$ztpChildrenCount = isset($_POST['ztpchildren']) ? intval($_POST['ztpchildren']) : 0;
$applyTaxDiscount = isset($_POST['taxdiscount']) ? true : false;
$disability1or2 = isset($_POST['disability1or2']) ? true : false;
$disability3 = isset($_POST['disability3']) ? true : false;
$ztpCardHolder = isset($_POST['ztpcard']) ? true : false;

// Constants
$averageSalary = 43967;
$x3Salary = 3 * $averageSalary;

// Rates
$taxRate = 0.15;
$taxRateX3 = 0.23;
$socialRate = 0.071;
$healthRate = 0.045;

// Discounts
$taxPayerDiscount = 2570;
$childrenDiscounts = [
    1267,
    1860,
    2320,
];


// Tax calculation
$tax = 0;
if ($grossSalary > $x3Salary) {
    $tax = round($grossSalary, -2) * $taxRateX3;
} else {
    $tax = round($grossSalary, -2) * $taxRate;
}
$taxDiscount = 0;
$taxBonus = 0;

if ($applyTaxDiscount) {
    $taxDiscount += $taxPayerDiscount;
}

for ($i = 0; $i < $childrenCount; $i++) {
    if ($i >= ($childrenCount - $ztpChildrenCount)) {
        $taxDiscount += $childrenDiscounts[min($i, 2)] * 2;
    } else {
        $taxDiscount += $childrenDiscounts[min($i, 2)];
    }
}

if ($disability1or2) {
    $taxDiscount += 210;
}

if ($disability3) {
    $taxDiscount += 420;
}

if ($ztpCardHolder) {
    $taxDiscount += 1345;
}

// $taxWithDiscounts = max(0, $tax - $taxDiscount);
$taxWithDiscounts = max($tax - $taxDiscount, 0);

if ($taxDiscount > $tax) {
    $taxBonus = $taxDiscount - $tax;
    $taxDiscount = $tax;
}

// Insurance calculation
$socialInsurance = ceil($grossSalary * $socialRate);
$healthInsurance = ceil($grossSalary * $healthRate);
$insurance = $socialInsurance + $healthInsurance;


$netSalary = $grossSalary - $tax + $taxDiscount - $insurance + $taxBonus;

$html = "<h2>Výpočet čisté mzdy</h2>";
$html .= "<table>";
$html .= "<tr><td>Hrubá mzda:</td><td>" . number_format($grossSalary, 2, ',', ' ') . " Kč</td></tr>";
$html .= "<tr><td>Daň (bez odečtení slev):</td><td>" . number_format($tax, 2, ',', ' ') . " Kč</td></tr>";
$html .= "<tr><td>Daň (s odečtením slev):</td><td>" . number_format($taxWithDiscounts, 2, ',', ' ') . " Kč</td></tr>";
$html .= "<tr><td class='nested'>Sleva na dani:</td><td class='nested'>" . number_format($taxDiscount, 2, ',', ' ') . " Kč</td></tr>";
$html .= "<tr><td class='nested'>Daňový bonus:</td><td class='nested'>" . number_format($taxBonus, 2, ',', ' ') . " Kč</td></tr>";
$html .= "<tr><td>Pojištění:</td><td>" . number_format($insurance, 2, ',', ' ') . " Kč</td></tr>";
$html .= "<tr><td class='nested'>Sociální pojištění:</td><td class='nested'>" . number_format($socialInsurance, 2, ',', ' ') . " Kč</td></tr>";
$html .= "<tr><td class='nested'>Zdravotní pojištění:</td><td class='nested'>" . number_format($healthInsurance, 2, ',', ' ') . " Kč</td></tr>";
$html .= "<tr><td><b>Čistá mzda:</b></td><td><b>" . number_format($netSalary, 2, ',', ' ') . " Kč</b></td></tr>";
$html .= "</table>";

$mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

$mpdf->Output();
