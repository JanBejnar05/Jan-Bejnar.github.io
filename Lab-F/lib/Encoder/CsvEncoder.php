<?php

class CsvEncoder implements EncoderInterface {

    private array $delimiters = [
        'csv'  => ',',
        'ssv'  => ';',
        'tsv'  => "\t"
    ];

    public function supports(string $format): bool {
        return array_key_exists($format, $this->delimiters);
    }

    public function decode(string $data): array {
        $format = $_POST['input_format'] ?? 'csv';
        $separator = $this->delimiters[$format] ?? ',';

        $lines = explode(PHP_EOL, trim($data));
        if (empty($lines)) return [];

        $headers = str_getcsv(array_shift($lines), $separator, '"', "");
        $result = [];

        foreach ($lines as $line) {
            if (empty(trim($line))) continue;

            $row = str_getcsv($line, $separator, '"', "");

            if (count($headers) === count($row)) {
                $result[] = array_combine($headers, $row);
            }
        }

        return $result;
    }

    public function encode(array $data): string {
        if (empty($data)) return '';

        $format = $_POST['output_format'] ?? 'csv';
        $separator = $this->delimiters[$format] ?? ',';

        $output = fopen('php://memory', 'r+');

        fputcsv($output, array_keys(reset($data)), $separator, '"', "", "\n");

        foreach ($data as $row) {
            fputcsv($output, $row, $separator, '"', "", "\n");
        }

        rewind($output);
        $csvContent = stream_get_contents($output);
        fclose($output);

        return rtrim($csvContent);
    }
}