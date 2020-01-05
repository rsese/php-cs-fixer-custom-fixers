<?php

declare(strict_types = 1);

namespace PhpCsFixerCustomFixers;

use PhpCsFixer\Tokenizer\Tokens;

/**
 * @internal
 */
final class TokenRemover
{
    public static function removeWithLinesIfPossible(Tokens $tokens, int $index): void
    {
        $tokenRemover = new \PhpCsFixer\Tokenizer\Manipulator\TokenRemover($tokens);

        $tokenRemover->clearToken($index);
    }
}
