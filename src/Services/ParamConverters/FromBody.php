<?php

namespace App\Services\ParamConverters;

use Attribute;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

#[Attribute(Attribute::TARGET_METHOD)]
class FromBody extends ParamConverter
{
    public function __construct(string $paramName, string $formTypeName)
    {
        parent::__construct(
            data: $paramName,
            class: null,
            options: ['formTypeName' => $formTypeName],
            isOptional: false,
            converter: null
        );
    }
}
