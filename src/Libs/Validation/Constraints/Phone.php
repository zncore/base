<?php

namespace ZnCore\Base\Libs\Validation\Constraints;

use ZnCore\Base\Enums\RegexpPatternEnum;

class Phone extends BaseRegex
{

    public function regexPattern(): string
    {
        return RegexpPatternEnum::PHONE_REQUIRED;
    }
}
