<?php

declare(strict_types = 1);

namespace Tests;

use PhpCsFixer\Tokenizer\Tokens;
use PhpCsFixerCustomFixers\CommentRemover;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @covers \PhpCsFixerCustomFixers\CommentRemover
 */
final class CommentRemoverTest extends TestCase
{
    /**
     * @param string      $expected
     * @param string|null $input
     *
     * @dataProvider provideFixCases
     */
    public function testFix(string $expected, string $input = null): void
    {
        $tokens = Tokens::fromCode($input);

        foreach ($tokens as $index => $token) {
            if ($token->isGivenKind([T_COMMENT, T_DOC_COMMENT])) {
                CommentRemover::removeCommentWithLinesIfPossible($tokens, $index);
                break;
            }
        }

        static::assertSame($expected, $tokens->generateCode());
    }

    public function provideFixCases(): \Iterator
    {
        yield [
            '<?php
namespace Foo;
',
            '<?php
/**
 * Some comment
 */
namespace Foo;
',
        ];
        yield [
            '<?php
namespace Foo;
',
            '<?php
// Some comment
namespace Foo;
',
        ];

        yield [
            '<?php

namespace Foo;
',
            '<?php

/**
 * Some comment
 */
namespace Foo;
',
        ];

        yield [
            '<?php

namespace Foo;
',
            '<?php
/**
 * Some comment
 */

namespace Foo;
',
        ];

        yield [
            '<?php


    namespace Foo;
',
            '<?php

    /**
     * Some comment
     */

    namespace Foo;
',
        ];

        yield [
            '<?php


    namespace Foo;
',
            '<?php

    // Some comment

    namespace Foo;
',
        ];

        yield [
            '<?php
                namespace Foo;
',
            '<?php
                /**
                 * Some comment
                 */
                namespace Foo;
',
        ];

        yield [
            '<?php
namespace Foo;
',
            '<?php
/** Some comment */namespace Foo;
',
        ];

        yield [
            '<?php
    namespace Foo;
',
            '<?php
/** Some comment */    namespace Foo;
',
        ];
    }
}