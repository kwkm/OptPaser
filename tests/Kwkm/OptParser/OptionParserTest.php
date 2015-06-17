<?php
namespace Kwkm\OptParser\Tests;

use Kwkm\OptParser;

require_once __DIR__ . '/../../bootstrap.php';

class OptionParserTest extends \PHPUnit_Framework_TestCase
{

    public function testOverwriteOption()
    {
        $testArgument = array(
            '-h',
            'localhost',
            '-h',
            'www.example.com',
        );

        $mock = \TestMock::on(
            new \Kwkm\OptParser\OptionParser($testArgument)
        );

        $parsedOption = $mock->getOption();
        $this->assertEquals('www.example.com', $parsedOption['-h']);
    }

    public function testParseOption()
    {
        $testArgument = array(
            '-v',
            '-e=shortEqual',
            '--equal=longEqual',
            '-s',
            'short',
            '--long',
            'long',
            '-abc',
            'argument',
            'filename'
        );

        $mock = \TestMock::on(
            new \Kwkm\OptParser\OptionParser($testArgument)
        );

        $parsedOption = $mock->getOption();
        $this->assertTrue($parsedOption['-a']);
        $this->assertTrue($parsedOption['-b']);
        $this->assertTrue($parsedOption['-c']);
        $this->assertTrue($parsedOption['-v']);
        $this->assertEquals('shortEqual', $parsedOption['-e']);
        $this->assertEquals('longEqual', $parsedOption['--equal']);
        $this->assertEquals('short', $parsedOption['-s']);
        $this->assertEquals('long', $parsedOption['--long']);

        $parsedArgument = $mock->getArgument();
        $this->assertTrue(in_array('argument', $parsedArgument));
        $this->assertTrue(in_array('filename', $parsedArgument));
        $this->assertFalse(in_array('-v', $parsedArgument));
        $this->assertFalse(in_array('shortEqual', $parsedArgument));
    }
}