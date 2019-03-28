# PHP CS Fixer: custom fixers

[![Latest Stable Version](https://img.shields.io/packagist/v/kubawerlos/php-cs-fixer-custom-fixers.svg)](https://packagist.org/packages/kubawerlos/php-cs-fixer-custom-fixers)
[![PHP Version](https://img.shields.io/badge/php-%5E7.1-8892BF.svg)](https://php.net)
[![License](https://img.shields.io/github/license/kubawerlos/php-cs-fixer-custom-fixers.svg)](https://packagist.org/packages/kubawerlos/php-cs-fixer-custom-fixers)
[![Build Status](https://img.shields.io/travis/kubawerlos/php-cs-fixer-custom-fixers/master.svg)](https://travis-ci.org/kubawerlos/php-cs-fixer-custom-fixers)
[![Code coverage](https://img.shields.io/coveralls/github/kubawerlos/php-cs-fixer-custom-fixers/master.svg)](https://coveralls.io/github/kubawerlos/php-cs-fixer-custom-fixers?branch=master)

A set of custom fixers for [PHP CS Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer).

## Installation
PHP CS Fixer: custom fixers can be installed by running:
```bash
composer require --dev kubawerlos/php-cs-fixer-custom-fixers
```


## Usage
In your PHP CS Fixer configuration register fixers and use them:
```diff
 <?php
 return PhpCsFixer\Config::create()
+    ->registerCustomFixers(new PhpCsFixerCustomFixers\Fixers())
     ->setRules([
         '@PSR2' => true,
         'array_syntax' => ['syntax' => 'short'],
+        PhpCsFixerCustomFixers\Fixer\NoLeadingSlashInGlobalNamespaceFixer::name() => true,
+        PhpCsFixerCustomFixers\Fixer\PhpdocNoSuperfluousParamFixer::name() => true,
     ]);
```


## Fixers
- **ImplodeCallFixer** - function `implode` must be called with 2 arguments in the documented order.  
  DEPRECATED: use `implode_call` instead.  
  *Risky: when the function `implode` is overridden.*
```diff
 <?php
-implode($foo, "") . implode($bar);
+implode("", $foo) . implode('', $bar);
```

- **InternalClassCasingFixer** - class defined internally by an extension, or the core should be called using the correct casing.
```diff
 <?php
-$foo = new STDClass();
+$foo = new stdClass();
```

- **MultilineCommentOpeningClosingAloneFixer** - multiline comment/PHPDoc must have opening and closing line without any extra content.
```diff
 <?php
-/** Hello
+/**
+ * Hello
  * World!
  */;
```

- **NoCommentedOutCodeFixer** - there should be no commented out code.
```diff
 <?php
-//var_dump($_POST);
 print_r($_POST);
```

- **NoDoctrineMigrationsGeneratedCommentFixer** - there must be no comment generated by Doctrine Migrations.
```diff
 <?php
 namespace Migrations;
 use Doctrine\DBAL\Schema\Schema;
-/**
- * Auto-generated Migration: Please modify to your needs!
- */
 final class Version20180609123456 extends AbstractMigration
 {
     public function up(Schema $schema)
     {
-        // this up() migration is auto-generated, please modify it to your needs
         $this->addSql("UPDATE t1 SET col1 = col1 + 1");
     }
     public function down(Schema $schema)
     {
-        // this down() migration is auto-generated, please modify it to your needs
         $this->addSql("UPDATE t1 SET col1 = col1 - 1");
     }
 }
```

- **NoImportFromGlobalNamespaceFixer** - there must be no import from global namespace.
```diff
 <?php
 namespace Foo;
-use DateTime;
 class Bar {
-    public function __construct(DateTime $dateTime) {}
+    public function __construct(\DateTime $dateTime) {}
 }
```

- **NoLeadingSlashInGlobalNamespaceFixer** - when in global namespace there must be no leading slash for class.
```diff
 <?php
-$x = new \Foo();
+$x = new Foo();
 namespace Bar;
 $y = new \Baz();
```

- **NoNullableBooleanTypeFixer** - there must be no nullable boolean type.  
  *Risky: when the null is used.*
```diff
 <?php
-function foo(?bool $bar) : ?bool
+function foo(bool $bar) : bool
 {
      return $bar;
  }
```

- **NoPhpStormGeneratedCommentFixer** - there must be no comment generated by PhpStorm.
```diff
 <?php
-/**
- * Created by PhpStorm.
- * User: root
- * Date: 01.01.70
- * Time: 12:00
- */
 namespace Foo;
```

- **NoReferenceInFunctionDefinitionFixer** - there must be no reference in function definition.  
  *Risky: when rely on reference.*
```diff
 <?php
-function foo(&$x) {}
+function foo($x) {}
```

- **NoTwoConsecutiveEmptyLinesFixer** - there must be no two consecutive empty lines in code.  
  DEPRECATED: use `no_extra_blank_lines` instead.
```diff
 <?php
 namespace Foo;
 
-
 class Bar {};
```

- **NoUnneededConcatenationFixer** - there should not be inline concatenation of strings.
```diff
 <?php
-echo 'foo' . 'bar';
+echo 'foobar';
```

- **NoUselessClassCommentFixer** - there must be no comment like: "Class FooBar".  
  DEPRECATED: use `NoUselessCommentFixer` instead.
```diff
 <?php
 /**
- * Class FooBar
  * Class to do something
  */
 class FooBar {}
```

- **NoUselessCommentFixer** - there must be no comment like "Class Foo".
```diff
 <?php
 /**
- * Class Foo
  * Class to do something
  */
 class Foo {
     /**
-     * Get bar
      */
     function getBar() {}
 }
```

- **NoUselessConstructorCommentFixer** - there must be no comment like: "Foo constructor".  
  DEPRECATED: use `NoUselessCommentFixer` instead.
```diff
 <?php
 class Foo {
     /**
-     * Foo constructor
      */
     public function __construct() {}
 }
```

- **NoUselessDoctrineRepositoryCommentFixer** - there must be no comment generated by the Doctrine ORM.
```diff
 <?php
-/**
- * FooRepository
- *
- * This class was generated by the Doctrine ORM. Add your own custom
- * repository methods below.
- */
 class FooRepository extends EntityRepository {}
```

- **NullableParamStyleFixer** - nullable parameters must be written in the consistent style.
  Configuration options:
  - `style` (`'with_question_mark'`, `'without_question_mark'`): whether nullable parameter type should be prefixed or not with question mark; defaults to `with_question_mark`
```diff
 <?php
-function foo(int $x = null) {
+function foo(?int $x = null) {
 }
```

- **OperatorLinebreakFixer** - binary operators must always be at the beginning or at the end of the line.  
  *To be deprecated after [this](https://github.com/FriendsOfPHP/PHP-CS-Fixer/pull/4021) is merged and released.*
  Configuration options:
  - `only_booleans` (`bool`): whether to limit operators to only boolean ones; defaults to `false`
  - `position` (`'beginning'`, `'end'`): whether to place operators at the beginning or at the end of the line; defaults to `beginning`
```diff
 <?php
 function foo() {
-    return $bar ||
-        $baz;
+    return $bar
+        || $baz;
 }
```

- **PhpdocNoIncorrectVarAnnotationFixer** - `@var` must be correct in the code.
```diff
 <?php
-/** @var Foo $foo */
 $bar = new Foo();
```

- **PhpdocNoSuperfluousParamFixer** - there must be no superfluous parameters in PHPDoc.
```diff
 <?php
 /**
  * @param bool $b
- * @param int $i
  * @param string $s this is string
- * @param string $s duplicated
  */
 function foo($b, $s) {}
```

- **PhpdocParamOrderFixer** - `@param` annotations must be in the same order as function's parameters.
```diff
 <?php
 /**
+ * @param int $a
  * @param int $b
- * @param int $a
  * @param int $c
  */
 function foo($a, $b, $c) {}
```

- **PhpdocParamTypeFixer** - `@param` must have type.
```diff
 <?php
 /**
  * @param string $foo
- * @param        $bar
+ * @param mixed  $bar
  */
 function a($foo, $bar) {}
```

- **PhpdocSelfAccessorFixer** - in PHPDoc inside class or interface element `self` should be preferred over the class name itself.
```diff
 <?php
 class Foo {
     /**
-     * @var Foo
+     * @var self
      */
      private $instance;
 }
```

- **PhpdocSingleLineVarFixer** - `@var` annotation must be in single line when is the only content.
```diff
 <?php
 class Foo {
-    /**
-     * @var string
-     */
+    /** @var string */
     private $name;
 }
```

- **PhpdocVarAnnotationCorrectOrderFixer** - `@var` and `@type` annotations must have type and name in the correct order.  
  DEPRECATED: use `phpdoc_var_annotation_correct_order` instead.
```diff
 <?php
-/** @var $foo int */
+/** @var int $foo */
 $foo = 2 + 2;
```

- **SingleSpaceAfterStatementFixer** - a single space must follow - not followed by semicolon - statement.
  Configuration options:
  - `allow_linebreak` (`bool`): whether to allow statement followed by linebreak; defaults to `false`
```diff
 <?php
-$foo = new    Foo();
-echo$foo->__toString();
+$foo = new Foo();
+echo $foo->__toString();
```

- **SingleSpaceBeforeStatementFixer** - a single space must precede - not preceded by linebreak - statement.
```diff
 <?php
-$foo =new Foo();
+$foo = new Foo();
```


## Contributing
Request a feature or report a bug by creating [issue](https://github.com/kubawerlos/php-cs-fixer-custom-fixers/issues).

Alternatively, fork the repo, develop your changes, regenerate `README.md`:
```bash
src/Readme/run > README.md
```
make sure all checks pass:
```bash
composer analyse
```
and submit a pull request.
