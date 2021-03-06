<?php

namespace Remorhaz\JSON\Pointer\Parser\Lexer;

use Remorhaz\JSON\Pointer\Parser\Token;

/**
 * Stores scanned tokens.
 */
class TokenBuffer
{

    /**
     * List of tokens that have been read from source.
     *
     * @var Token[]
     */
    protected $tokenList = [];

    /**
     * Marks current position in token list.
     *
     * @var int
     */
    protected $cursor = 0;


    /**
     * Constructor.
     */
    protected function __construct()
    {
    }


    /**
     * Creates instance of object.
     *
     * @return static
     */
    public static function factory()
    {
        return new static();
    }


    /**
     * Checks if internal cursor points at the end of buffer.
     *
     * @return bool
     */
    public function isEnd(): bool
    {
        return count($this->tokenList) == $this->cursor;
    }


    public function addToken(Token $token)
    {
        $position = $this->getNextPosition();
        $this->tokenList[] = $token->setPosition($position);
        return $this;
    }


    public function getNextPosition(): int
    {
        return empty($this->tokenList)
            ? 0
            : $this
                ->getLastToken()
                ->getNextPosition();
    }


    /**
     * Reads token from current cursor position and advances cursor.
     *
     * @return Token
     */
    public function readToken(): Token
    {
        if ($this->isEnd()) {
            throw new LogicException("The end of buffer is reached");
        }
        $token = $this->getTokenAtIndex($this->cursor);
        $this->cursor++;
        return $token;
    }


    /**
     * Cancels reading of last token.
     *
     * @return $this
     */
    public function unreadToken()
    {
        if (0 == $this->cursor) {
            throw new LogicException("The beginning of buffer is reached");
        }
        $this->cursor--;
        return $this;
    }


    /**
     * @return Token
     */
    protected function getLastToken(): Token
    {
        $lastIndex = count($this->tokenList) - 1;
        return $this->getTokenAtIndex($lastIndex);
    }


    /**
     * Returns token at given index.
     *
     * @param int $index
     * @return Token
     */
    protected function getTokenAtIndex(int $index): Token
    {
        if (!$this->hasTokenAtIndex($index)) {
            throw new OutOfRangeException("No token in buffer at given index");
        }
        return $this->tokenList[$index];
    }


    /**
     * Checks if token exists at given index.
     *
     * @param int $index
     * @return bool
     */
    protected function hasTokenAtIndex(int $index): bool
    {
        return isset($this->tokenList[$index]);
    }
}
