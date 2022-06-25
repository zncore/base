<?php

namespace ZnCore\Base\Validation\Constraints;

use ZnLib\Components\Regexp\Enums\RegexpPatternEnum;

class Phone extends BaseRegex
{

    public function regexPattern(): string
    {
        return RegexpPatternEnum::PHONE_REQUIRED;
    }
}
