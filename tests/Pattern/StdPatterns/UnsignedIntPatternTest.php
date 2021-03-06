<?php

namespace Awesomite\Chariot\Pattern\StdPatterns;

use Awesomite\Chariot\Pattern\PatternInterface;
use Awesomite\Chariot\StringableObject;

class UnsignedIntPatternTest extends IntPatternTest
{
    public function getPattern(): PatternInterface
    {
        return new UnsignedIntPattern();
    }

    public function providerToUrl()
    {
        return [
            [0, '0'],
            ['0', '0'],
            [100, '100'],
            [new StringableObject('0'), '0'],
            [new StringableObject((string) PHP_INT_MAX), (string) PHP_INT_MAX],
        ];
    }

    public function providerInvalidToUrl()
    {
        $result = [
            [-5],
            ['-5'],
        ];

        return array_merge($result, parent::providerInvalidToUrl());
    }

    public function providerFromUrl()
    {
        yield ['10', 10];
    }
}
