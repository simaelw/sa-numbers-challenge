<?php

namespace App\Helpers;

class NumberSanitizer
{
    public $prefix = '2783';

    /**
     * Validates the number if it is formatted correctly for South America
     *
     * @param string $number
     * @return boolean
     */
    public function validate(string $number): bool
    {
        if (preg_match("/^2783[0-9]{7}$/", $number) === 1) {
            return true;
        }

        return false;
    }

    /**
     * Attempts to correct number format to validate
     *
     * @param string $number
     * @return array
     */
    public function correct(string $number): array
    {
        // Missing prefix check
        if (strlen($number) === 7) {
            $addedPrefixNumber = $this->prefix . $number;

            if ($this->validate($addedPrefixNumber)) {
                return [
                    'valid' => true,
                    'modified' => true,
                    'number' => $addedPrefixNumber,
                    'modified_action' => 'Prefix added'
                ];
            }
        }

        // Parsed number without _DELETED_ part check
        $parsedNumber = explode("_DELETED_", $number)[0];

        if ($this->validate($parsedNumber)) {
            return [
                'valid' => true,
                'modified' => true,
                'number' => $parsedNumber,
                'modified_action' => 'Parsed number removing _DELETED_ part'
            ];
        }

        // Parsed number without _DELETED_ part with manual add prefix check
        $addedPrefixParsedNumber = $this->prefix . $parsedNumber;

        if ($this->validate($addedPrefixParsedNumber)) {
            return [
                'valid' => true,
                'modified' => true,
                'number' => $addedPrefixParsedNumber,
                'modified_action' => 'Parsed number removing _DELETED_ part; Prefix added'
            ];
        }

        return [
            'valid' => false,
            'modified' => false,
            'number' => false,
            'modified_action' => null
        ];
    }

    public function validateOrCorrect(string $number): array
    {
        if ($this->validate($number) === true) {
            return [
                'valid' => true,
                'modified' => false,
                'number' => $number,
                'modified_action' => null
            ];
        }

        return $this->correct($number);
    }
}
