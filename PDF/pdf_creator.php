<?php
if (!$_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "You have to fill the form first!";
}

require_once __DIR__ . '/../vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => "A4-L",
    'margin_left' => 10,
    'margin_right' => 10,
    'margin_top' => 10,
    'margin_bottom' => 10
]);

$stylesheet = file_get_contents("./style.css");
$mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);

$grossSalary = floatval($_POST['gross_salary']);
$childrenCount = intval($_POST['children']);

$taxRate = 0.15;
$socialRate = 0.071;
$healthRate = 0.045;
$children = [
    1267,
    1860,
    2320,
];
$childrenZTP = [
    2534,
    3720,
    4640
];

$tax = round($grossSalary, -2) * $taxRate;
$socialInsurance = ceil($grossSalary * $socialRate);
$healthInsurance = ceil($grossSalary * $healthRate);

$childrenAllowance = 0;
if ($childrenCount > 0 && $childrenCount) {
    if ($childrenCount > 2) {
        $childrenAllowance = $children[0] + $children[1] + $children[2] * ($childrenCount - 2);
    } else {
        $childrenAllowance = $children[$childrenCount];
    }
}

$taxAllowance = $tax;
$taxAllowance -= 2570;
$taxAllowance -= $childrenAllowance;

$insurance = $socialInsurance + $healthInsurance;
$netSalary = $grossSalary - $taxAllowance - $insurance;

$html = "<h2>Výpočet čisté mzdy</h2>";
$html .= "<table>";
$html .= "<tr><td>Hrubá mzda:</td><td>$grossSalary Kč</td></tr>";
$html .= "<tr><td>Daň:</td><td>$tax Kč</td></tr>";
$html .= "<tr><td>Pojištění:</td><td>$insurance Kč</td></tr>";
$html .= "<tr><td>&nbsp;&nbsp;&nbsp;Sociální pojištění:</td><td>$socialInsurance Kč</td></tr>";
$html .= "<tr><td>&nbsp;&nbsp;&nbsp;Zdravotní pojištění:</td><td>$healthInsurance Kč</td></tr>";
$html .= "<tr><td>Sleva na dítěti:</td><td>$childrenAllowance Kč</td></tr>";
$html .= "<tr><td>Čistá mzda:</td><td>$netSalary Kč</td></tr>";
$html .= "</table>";

$mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

$mpdf->Output();
