<?php

namespace Remorhaz\JSONPointer\Test\Parser\Lexer\Scanner;

use Remorhaz\JSONPointer\Parser\Lexer\Scanner;

/**
 */
class TextTest extends \PHPUnit_Framework_TestCase
{


    /**
     * @expectedException \Remorhaz\JSONPointer\Parser\Lexer\Scanner\Exception
     */
    public function testUninitializedTextAccessThrowsException()
    {
        Scanner::factory()->getText();
    }


    /**
     * @expectedException \RuntimeException
     */
    public function testUninitializedTextAccessThrowsSplException()
    {
        Scanner::factory()->getText();
    }


    /**
     * @dataProvider providerText
     */
    public function testGotTextSameAsSet($text)
    {
        $scanner = Scanner::factory()->setText($text);
        $this->assertEquals($text, $scanner->getText(), "Got text differs from the one that was set");
    }


    public function providerText()
    {
        return [
            'emptyText' => [''],
            'whitespaceText' => [" \r\n\f\t\v"],
            'latinText' => ['abc'],
            'cyrillicText' => ['абв'],
            'kanjiText' => ['日本語'],
            'mixedText' => ["a\tб 日~1"],
        ];
    }


    /**
     */
    public function testIsEndAfterSettingEmptyText()
    {
        $scanner = Scanner::factory()->setText('');
        $this->assertTrue($scanner->isEnd(), "End of text is not reached after setting empty string");
    }


    /**
     */
    public function testIsNotEndAfterSettingNonEmptyText()
    {
        $scanner = Scanner::factory()->setText('abc');
        $this->assertFalse($scanner->isEnd(), "End of text is reached after setting non-empty string");
    }


    /**
     * @param string $text
     * @dataProvider providerBrokenUnicodeText
     * @expectedException \Remorhaz\JSONPointer\Parser\Lexer\Scanner\RegExpException
     * @expectedExceptionCode PREG_BAD_UTF8_ERROR
     * @expectedExceptionMessage PREG_BAD_UTF8_ERROR
     */
    public function testSettingBrokenUnicodeTextThrowsException($text)
    {
        Scanner::factory()->setText($text);
    }


    /**
     * @param string $text
     * @dataProvider providerBrokenUnicodeText
     * @expectedException \RuntimeException
     */
    public function testSettingBrokenUnicodeTextThrowsSplException($text)
    {
        Scanner::factory()->setText($text);
    }


    public function providerBrokenUnicodeText()
    {
        return [
            'singleBrokenUnicode' => [substr('日', -1, 1)],
            'containsBrokenUnicode' => ['аб' . substr('в', -1, 1) . 'г'],
        ];
    }
}