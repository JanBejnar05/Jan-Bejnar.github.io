<?php

class YamlEncoder implements EncoderInterface {

    public function supports(string $format): bool {
        return $format === 'yaml';
    }

    public function decode(string $data): array {
        if (empty(trim($data))) {
            return [];
        }

        $decoded = yaml_parse($data);

        return is_array($decoded) ? $decoded : [];
    }

    public function encode(array $data): string {
        if (empty($data)) {
            return '';
        }

        return yaml_emit($data, YAML_UTF8_ENCODING);
    }
}