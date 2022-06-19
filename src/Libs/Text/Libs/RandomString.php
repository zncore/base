<?php

namespace ZnCore\Base\Libs\Text\Libs;

use Symfony\Component\String\ByteString;

class RandomString
{

    private $length = 0;
    private $characters = '';
    private $hightQuality = false;

    public function getLength(): int
    {
        return $this->length;
    }

    public function setLength(int $length): void
    {
        $this->length = $length;
    }

    public function getCharacters(): string
    {
        return $this->characters;
    }

    public function setCharacters(string $characters): void
    {
        $this->characters = $characters;
    }

    public function addCharactersNumber(): void
    {
        $this->characters .= '0123456789';
    }

    public function addCharactersLower(): void
    {
        $this->characters .= 'abcdefghijklmnopqrstuvwxyz';
    }

    public function addCharactersUpper(): void
    {
        $this->characters .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    }

    public function addCharactersSpecChar(): void
    {
        $this->characters .= '!"#$%&\'()*+,-./:;<=>?@[\\]^_`{|}~';
    }

    public function addCustomChar(string $chars): void
    {
        $this->characters .= $chars;
    }

    public function addCharactersAll(): void
    {
        $this->addCharactersNumber();
        $this->addCharactersLower();
        $this->addCharactersUpper();
        $this->addCharactersSpecChar();
    }

    public function isHightQuality(): bool
    {
        return $this->hightQuality;
    }

    public function setHightQuality(bool $hightQuality): void
    {
        $this->hightQuality = $hightQuality;
    }

    public function generateString(): string
    {
        $this->validate();
        return ByteString::fromRandom($this->getLength(), $this->getCharacters())->toString();


        /*$charactersCount = strlen($this->characters);
        $randstring = '';
        for ($i = 0; $i < $this->length; $i++) {
            $randstring .= $this->generateChar();
        }
        return $randstring;*/
    }

    /*public function generateChar(): string
    {
        $charactersCount = strlen($this->characters);
        $randomNumber = mt_rand(0, $charactersCount - 1);
        return $this->characters[$randomNumber];
    }*/

    private function validate()
    {
        if ($this->length == 0) {
            throw new \Exception('Length is 0');
        }
        if (empty($this->characters)) {
            throw new \Exception('Empty characters');
        }
    }
}
