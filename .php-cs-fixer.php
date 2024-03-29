<?php

$rules = [
    '@Symfony' => true,
    '@Symfony:risky' => true,
    '@PSR2' => true,
    'concat_space' => [
        'spacing' => 'one'
    ],
    'line_ending' => false,
];

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__);

$config = (new PhpCsFixer\Config())
    ->setFinder($finder)
    ->setRules($rules)
    ->setRiskyAllowed(true);

return $config;
