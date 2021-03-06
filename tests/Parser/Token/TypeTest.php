<?php

namespace Remorhaz\JSON\Pointer\Test\Parser\Token;

use PHPUnit\Framework\TestCase;
use Remorhaz\JSON\Pointer\Parser\Token;

class TypeTest extends TestCase
{


    /**
     * @expectedException \Remorhaz\JSON\Pointer\Parser\Exception
     */
    public function testAccessingUninitializedTypeThrowsException()
    {
        Token::factory()->getType();
    }


    /**
     * @expectedException \LogicException
     */
    public function testAccessingUninitializedTypeThrowsSplException()
    {
        Token::factory()->getType();
    }


    /**
     */
    public function testGotTypeSameAsSet()
    {
        $type = Token::TYPE_SLASH;
        $token = Token::factory()->setType($type);
        $this->assertEquals($type, $token->getType(), "Got type differs from the one that was set");
    }


    /**
     * @expectedException \Remorhaz\JSON\Pointer\Parser\Exception
     */
    public function testSettingInvalidTypeThrowsException()
    {
        Token::factory()->setType(0xFF);
    }


    /**
     * @expectedException \DomainException
     */
    public function testSettingInvalidTypeThrowsSplException()
    {
        Token::factory()->setType(0xFF);
    }


    /**
     */
    public function testIsErrorAfterSettingErrorType()
    {
        $token = Token::factory()->setType(Token::TYPE_ERROR_INVALID_ESCAPE);
        $this->assertTrue($token->isError(), "No error in token after setting error type");
    }


    /**
     */
    public function testNoErrorAfterSettingNonErrorType()
    {
        $token = Token::factory()->setType(Token::TYPE_SLASH);
        $this->assertFalse($token->isError(), "Error in token after setting non-error type");
    }
}
