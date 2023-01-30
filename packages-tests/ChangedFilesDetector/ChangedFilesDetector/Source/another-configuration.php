<?php

declare(strict_types=1);

use Symplify\EasyCodingStandard\Config\ECSConfig;

return static function (ECSConfig $ecsConfig): void {
    $parameters = $ecsConfig->parameters();
    $parameters->set('one', 'configuration-2');
};