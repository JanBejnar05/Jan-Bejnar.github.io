<?php

class YamlEncoder implements EncoderInterface {

    public function supports(string $format): bool {
        return $format === 'yaml';
    }

    public function decode(string $data): array {
        if (empty(trim($data))) {
            return [];
        }

        // Funkcja yaml_parse zwraca tablicę lub false w przypadku błędu
        $decoded = yaml_parse($data);

        return is_array($decoded) ? $decoded : [];
    }

    public function encode(array $data): string {
        if (empty($data)) {
            return '';
        }

        // yaml_emit generuje gotowy ciąg znaków YAML
        return yaml_emit($data, YAML_UTF8_ENCODING);
    }
}