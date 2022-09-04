<?php

declare(strict_types=1);

$config = (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@DoctrineAnnotation' => true,
        '@PHP74Migration' => true,
        '@PHP80Migration' => true,
        '@PHP80Migration:risky' => true,
        '@PHPUnit84Migration:risky' => true,
        '@PhpCsFixer' => true,
        '@PhpCsFixer:risky' => true,
        '@PSR12' => true,
        '@PSR12:risky' => true,
        'comment_to_phpdoc' => false,
        'global_namespace_import' => true,
        'nullable_type_declaration_for_default_null_value' => true,
        'php_unit_strict' => true,
        'php_unit_test_class_requires_covers' => false,
        'phpdoc_line_span' => true,
    ])
;

$config->getFinder()
    ->in(__DIR__.'/src')
    ->in(__DIR__.'/tests')
;

return $config;