<?php

namespace Remorhaz\JSON\Pointer\Parser;

/**
 * Helper to assert PREG function results.
 */
abstract class PregHelper
{


    public static function assertValidUTF8(string $text, string $exceptionClass, string $message)
    {
        $result = preg_match('#^.*$#su', $text);
        PregHelper::assertMatchResult(
            $result,
            $exceptionClass,
            $message
        );
    }


    public static function assertMatchResult($result, string $exceptionClass, string $message)
    {
        if (false !== $result) {
            return; // No error.
        }
        $errorCode = preg_last_error();
        $errorMessage = self::buildPregErrorMessage($errorCode);
        throw new $exceptionClass(
            "{$message}: {$errorMessage}",
            $errorCode
        );
    }


    private static function buildPregErrorMessage(int $errorCode): string
    {
        $errorNameList = [
            'PREG_NO_ERROR',
            'PREG_INTERNAL_ERROR',
            'PREG_BACKTRACK_LIMIT_ERROR',
            'PREG_RECURSION_LIMIT_ERROR',
            'PREG_BAD_UTF8_ERROR',
            'PREG_BAD_UTF8_OFFSET_ERROR',
            'PREG_JIT_STACKLIMIT_ERROR',
        ];
        $errorName = null;
        foreach ($errorNameList as $listedErrorName) {
            if (defined($listedErrorName) && constant($listedErrorName) == $errorCode) {
                $errorName = $listedErrorName;
                break;
            }
        }
        if (null === $errorName) {
            $errorName = 'Unknown error';
        }
        return "{$errorName} ({$errorCode})";
    }
}