<?php

namespace ZnCore\Base\Libs\Shell;

class ShellResultEntity
{

    private $output = [];
    private $exitCode = null;

    public function getOutput(): array
    {
        return $this->output;
    }

    public function getOutputString(): ?string
    {
        if (!$this->getOutput()) {
            return null;
        }
        $string = implode(PHP_EOL, $this->getOutput());
        return trim($string);
    }

    public function setOutput(array $output): void
    {
        $this->output = $output;
    }

    public function getExitCode()
    {
        return $this->exitCode;
    }

    public function setExitCode($exitCode): void
    {
        $this->exitCode = $exitCode;
    }
}
