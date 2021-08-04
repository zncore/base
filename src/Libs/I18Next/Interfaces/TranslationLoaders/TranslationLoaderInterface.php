<?php

namespace ZnCore\Base\Libs\I18Next\Interfaces\TranslationLoaders;

interface TranslationLoaderInterface
{

    public function load(string $language): array;
}
