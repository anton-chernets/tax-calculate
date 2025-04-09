<?php

use App\Services\FileReaderService;
use PHPUnit\Framework\TestCase;

class FileReaderServiceTest extends TestCase
{
    private FileReaderService $fileProcessor;
    private string $testFile = 'test.txt';

    protected function setUp(): void
    {
        file_put_contents($this->testFile, "Line 1\nLine 2\nLine 3\n");
        $this->fileProcessor = new FileReaderService($this->testFile);
    }

    protected function tearDown(): void
    {
        unlink($this->testFile);
    }

    public function testGetFileContent()
    {
        $content = $this->fileProcessor->getFileContent();
        $this->assertEquals("Line 1\nLine 2\nLine 3\n", $content);
    }

    public function testConvertFileToArray()
    {
        $result = $this->fileProcessor->convertFileToArray();

        $this->assertEquals(['Line 1', 'Line 2', 'Line 3'], $result);
    }
}
