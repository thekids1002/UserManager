<?php

namespace App\Libs;

use Illuminate\Support\Facades\Validator;
use PSpell\Config;
use Symfony\Component\Yaml\Yaml;

class CSVUtil
{
    public function __construct() {
    }

    /**
     * Export csv file with array data and fields
     *
     * @param array $data not null,
     * @param array $headers not null,
     * @return string
     */
    public static function exportCSVFile($data, $headers) {
        $file = fopen('php://output', 'w');

        $headerCopy = array_map(function ($value) {
            if (strpos($value, ' ') === false) {
                $value = '"' . $value . '"';
            }

            return $value;
        }, $headers);

        ob_start();

        fputcsv($file, $headerCopy);

        foreach ($data as $item) {
            $lineData = [];

            for ($i = 0; $i < count($headers); $i++) {
                $value = $item[$headers[$i]] ?? '';

                if (strpos($value, ' ') === false) {
                    $value = '"' . $value . '"';
                }

                $lineData[] = $value;
            }

            fputcsv($file, $lineData, ',', '"');
        }

        fclose($file);

        $csv = ob_get_clean();

        $csv = str_replace('""', '"', str_replace('""', '"', $csv));

        return $csv;
    }

    /**
     * Retrieve the header configuration from the YAML file.
     *
     * @param mixed $path
     * @return array The header configuration array.
     */
    // '/app/Constants/configImport.yaml'
    public function getHeaderFromConfigsYAML($path) {
        // Get Header of YAML
        $yamlContents = Yaml::parse(file_get_contents(base_path($path)));
        $headerConfig = [];
        foreach ($yamlContents['group_import_csv_configs'] as $key => $value) {
            $headerConfig[] = $value['header'];
        }

        return $headerConfig;
    }

    /**
     * Retrieve the header line from a CSV file.
     *
     * @param resource $file The file handle of the CSV file.
     * @return array|null The header line as an array, or null if the file is empty.
     */
    public function getHeaderCSVFile($file) {
        $headerLine = fgetcsv($file);

        return $headerLine;
    }

    /**
     * Compare the headers from a YAML file with the headers from a CSV file.
     *
     * @param array $yamlHeader The header array from the YAML file.
     * @param array $csvHeader The header array from the CSV file.
     * @return bool True if all CSV headers are present in the YAML headers, false otherwise.
     */
    public function checkHeader($yamlHeader, $csvHeader) {
        foreach ($csvHeader as $header) {
            if (! in_array($header, $yamlHeader)) {
                return false;
            }
        }

        return true;
    }

    public function getValidation($path, $configName) {
        $yamlContents = Yaml::parse(file_get_contents(base_path($path)));
        $rules = [];
        foreach ($yamlContents[$configName] as $key => $value) {
            $validConfig = $value['validate'];
            // $rules[] = $this->convertArrToValidateString($validConfig);
            $rules[] = $validConfig;
        }

        return $rules;
    }

    /**
     * Retrieve the keys from the YAML file.
     *
     * @param mixed $path
     * @param mixed $configName
     * @return array The array of keys from the YAML file.
     */
    public function getKeyYaml($path, $configName) {
        $yamlContents = Yaml::parse(file_get_contents(base_path($path)));
        $headerConfig = [];
        foreach ($yamlContents[$configName] as $key => $value) {
            $headerConfig[] = $key;
        }

        return $headerConfig;
    }

    
}
