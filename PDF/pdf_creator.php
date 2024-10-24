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

$gross = floatval($_POST['gross_salary']);
$childrenCount = intval($_POST['children']);

$taxRate = 0.15;
$socialRate = 0.071;
$healthRate = 0.045;
$children = [
    1267,
    3127,
    5447,
];


$html = "<h1>Salary Details</h1>";
$html .= "<p>Gross Salary: {$grossSalary}</p>";
$html .= "<p>Tax: {$tax}</p>";
$html .= "<p>Insurance: {$insurance}</p>";
$html .= "<p>Net Salary: {$netSalary}</p>";

$mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

$mpdf->Output();
