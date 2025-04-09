<?php

namespace App\Validators;

class InputFileValidator
{
    public static function validateFilename(array $argv): string
    {
        $fileName = $argv[1] ?? null;

        if (is_null($fileName)) {
            exit("error filename php app.php <filename>\n");
        }

        return $fileName;
    }

}