<?php
require_once 'autoload.php';

$inputData = $_COOKIE['input_data'] ?? '';
$inputFormat = $_COOKIE['input_format'] ?? 'csv';
$outputFormat = $_COOKIE['output_format'] ?? 'json';
$result = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputData = $_POST['input_data'] ?? '';
    $inputFormat = $_POST['input_format'] ?? 'csv';
    $outputFormat = $_POST['output_format'] ?? 'json';

    setcookie('input_data', $inputData, time() + (86400 * 30), "/");
    setcookie('input_format', $inputFormat, time() + (86400 * 30), "/");
    setcookie('output_format', $outputFormat, time() + (86400 * 30), "/");

    try {
        $encoders = [new CsvEncoder(), new JsonEncoder(), new YamlEncoder()];
        $serializer = new Serializer($encoders);

        if (!empty($inputData)) {
            $result = $serializer->convert($inputData, $inputFormat, $outputFormat);
        }
    } catch (Exception $e) {
        $result = "Błąd: " . $e->getMessage();
    }
}

require_once 'templates/layout.php';