<?php

namespace ZnCore\Base\Libs\Shell;

class CommandForm
{

    private $lang = '';
    private $command;
    private $arguments = [];
    private $path = '.';

    public function getLang(): string
    {
        return $this->lang;
    }

    public function setLang(string $lang): void
    {
        $this->lang = $lang;
    }

    public function getCommand()
    {
        return $this->command;
    }

    public function setCommand($command): void
    {
        $this->command = $command;
    }

    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function setArguments(array $arguments): void
    {
        $this->arguments = $arguments;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path): void
    {
        $this->path = $path;
    }
}


/*
$commandForm = new CommandForm();
$commandForm->setPath($path);
$commandForm->setCommandItems([
    'php',
    'zn',
    'queue:run',
    $channel,
    "--wrapped=1",
]);

$process = new Process($commandForm->getCommand(), $commandForm->getPath());
*/
