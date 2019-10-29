<?php

$finder = PhpCsFixer\Finder::create()
    ->in(['src', 'tests'])
;

return PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
        'declare_strict_types' => true,
        'phpdoc_summary' => false,
        'single_trait_insert_per_statement' => false,
        'ordered_imports' => true,
        'array_syntax' => ['syntax' => 'short'],
        'phpdoc_no_empty_return' => false,
        'no_empty_comment' => false,
        'new_with_braces' => false,
        'yoda_style' => false,
    ])
    ->setFinder($finder)
    ->setUsingCache(false)
;
