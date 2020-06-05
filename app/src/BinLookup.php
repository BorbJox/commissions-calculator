<?php


namespace App;


use App\Exceptions\APIErrorException;
use App\Exceptions\APIMissingDataException;

class BinLookup implements CardCountryProvider
{

    /**
     * Returns the country in ISO 3166-1 alpha-2 format
     *
     * @param string $bin
     * @return mixed
     * @throws \Exception
     */
    public function getCardCountry(string $bin)
    {
        $content = file_get_contents('https://lookup.binlist.net/' .$bin);
        if ($content === false) {
            throw new APIErrorException('Bin lookup API could not be reached.');
        }

        $binResults = json_decode($content, true);
        if (isset($binResults['country']['alpha2'])) {
            return $binResults['country']['alpha2'];
        } else {
            throw new APIMissingDataException('Bin lookup API did not return the card\'s country for BIN '.$bin);
        }
    }
}