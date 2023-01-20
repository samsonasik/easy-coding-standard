<?php

declare (strict_types=1);
/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace PhpCsFixer\FixerConfiguration;

/**
 * @author ntzm
 *
 * @internal
 */
final class AliasedFixerOptionBuilder
{
    /**
     * @var \PhpCsFixer\FixerConfiguration\FixerOptionBuilder
     */
    private $optionBuilder;
    /**
     * @var string
     */
    private $alias;
    public function __construct(\PhpCsFixer\FixerConfiguration\FixerOptionBuilder $optionBuilder, string $alias)
    {
        $this->optionBuilder = $optionBuilder;
        $this->alias = $alias;
    }
    /**
     * @param mixed $default
     */
    public function setDefault($default) : self
    {
        $this->optionBuilder->setDefault($default);
        return $this;
    }
    /**
     * @param list<string> $allowedTypes
     */
    public function setAllowedTypes(array $allowedTypes) : self
    {
        $this->optionBuilder->setAllowedTypes($allowedTypes);
        return $this;
    }
    /**
     * @param list<(callable(mixed): bool)|null|scalar> $allowedValues
     */
    public function setAllowedValues(array $allowedValues) : self
    {
        $this->optionBuilder->setAllowedValues($allowedValues);
        return $this;
    }
    public function setNormalizer(\Closure $normalizer) : self
    {
        $this->optionBuilder->setNormalizer($normalizer);
        return $this;
    }
    public function getOption() : \PhpCsFixer\FixerConfiguration\AliasedFixerOption
    {
        return new \PhpCsFixer\FixerConfiguration\AliasedFixerOption($this->optionBuilder->getOption(), $this->alias);
    }
}
