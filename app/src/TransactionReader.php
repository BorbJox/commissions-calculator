<?php

namespace App;

use App\Exceptions\FileReadException;

class TransactionReader
{
    /**
     * Reads each line in a file as JSON. Assumes transaction contents are valid.
     *
     * @param string $filename
     * @return array
     * @throws \Exception
     */
    public static function readFile(string $filename)
    {
        $transactions = array();
        $contents = file_get_contents($filename);

        if ($contents === false) {
            throw new FileReadException('Failed to read from file: "' . $filename . '"');
        }

        $lines = explode("\n", $contents);
        foreach ($lines as $line) {
            $clean_line = trim($line);
            if (empty($clean_line)) {
                //Skip empty lines
                continue;
            }
            $decoded_line = json_decode(trim($line), true);
            if (!is_null($decoded_line)) {
                $transactions[] = $decoded_line;
            }
        }
        return $transactions;

    }
}