<?php

declare (strict_types=1);
namespace ECSPrefix20210628\Symplify\RuleDocGenerator\Contract;

use ECSPrefix20210628\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
interface DocumentedRuleInterface
{
    public function getRuleDefinition() : \ECSPrefix20210628\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
}
