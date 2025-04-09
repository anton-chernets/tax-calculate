<?php

namespace App\Services;

class FileReaderService
{
    private string $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function getFileContent(): string
    {
        return file_get_contents($this->filePath);
    }

    public function convertFileToArray(): array
    {
        $content = $this->getFileContent();
        $rows = explode("\n", $content);

        $result = [];
        foreach ($rows as $row) {
            if (empty($row)) {
                continue;
            }
            $result[] = $row;
        }

        return $result;
    }
}
