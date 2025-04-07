<?php

use App\App\FileReader;
use PHPUnit\Framework\TestCase;

class FileReaderTest extends TestCase
{
    private FileReader $fileProcessor;
    private string $testFile = 'test.txt';

    protected function setUp(): void
    {
        file_put_contents($this->testFile, "Line 1\nLine 2\nLine 3\n");
        $this->fileProcessor = new FileReader($this->testFile);
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