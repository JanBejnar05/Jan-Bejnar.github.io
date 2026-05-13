<?php

class Serializer {
    private array $encoders;

    public function __construct(array $encoders) {
        $this->encoders = $encoders;
    }

    public function convert(string $data, string $inputFormat, string $outputFormat): string {
        $decodedData = null;

        // Znajdź enkoder do odczytu
        foreach ($this->encoders as $encoder) {
            if ($encoder->supports($inputFormat)) {
                $decodedData = $encoder->decode($data);
                break;
            }
        }

        if ($decodedData === null) throw new Exception("Nieobsługiwany format wejściowy.");

        // Znajdź enkoder do zapisu
        foreach ($this->encoders as $encoder) {
            if ($encoder->supports($outputFormat)) {
                return $encoder->encode($decodedData);
            }
        }

        throw new Exception("Nieobsługiwany format wyjściowy.");
    }
}