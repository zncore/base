<?php

namespace ZnCore\Base\Libs\Shell;

use ZnCore\Base\Enums\OsFamilyEnum;
use ZnCore\Base\Helpers\OsHelper;

class ShellCommand
{

    private $path;
    private $lang = 'en_GB';
    private $optionGlue = '=';

    private $cwd = null;
    private $output = [];
    private $exitCode = null;

    /*public function __construct(?string $path = null)
    {
        $this->setPath($path);
    }*/

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path)
    {
        $path = realpath($path);
        if ($path === false) {
            throw new ShellException("Path '$path' not found.");
        }
        $this->path = $path;
    }

    public function getLang(): string
    {
        return $this->lang;
    }

    public function setLang(string $lang): void
    {
        $this->lang = $lang;
    }

    protected function begin()
    {
        if ($this->cwd === null) {
            $this->cwd = getcwd();
            chdir($this->getPath());
        }
        return $this;
    }

    protected function end()
    {
        if (is_string($this->cwd)) {
            chdir($this->cwd);
        }
        $this->cwd = null;
        return $this;
    }

    protected function prepareCmd(string $cmd): string
    {
        if (OsHelper::isFamily(OsFamilyEnum::LINUX)) {
            $cmd = 'LANG=' . $this->getLang() . ' ' . $cmd;
        }
        return $cmd;
    }

    public function runBatch(array $cmds): ShellResultEntity
    {
        $cmd = new \ZnLib\Console\Symfony4\Libs\Command();
        foreach ($cmds as $cmdLine) {
            $cmd->add($cmdLine);
        }
        $command = $cmd->toString();
        return $this->run($command);
    }

    public function run($cmd): ShellResultEntity
    {
        if(is_array($cmd)) {
            $cmd = $this->processCommand($cmd);
        }
        $output = [];
        $exitCode = null;
        $this->begin();
        $cmd = $this->prepareCmd($cmd);
        exec($cmd, $output, $exitCode);
        $this->end();
        if (/*$exitCode !== 0 || */ !is_array($output)) {
            throw new ShellException("Command $cmd failed.");
        }

//        $output = $this->filterOutputLines($output, $filter);
        /*if (!isset($output[0])) // empty array
        {
            return null;
        }*/

        $shellResultEntity = new ShellResultEntity();
        $shellResultEntity->setExitCode($exitCode);
        $shellResultEntity->setOutput($output);
        return $shellResultEntity;


        $this->output = $output;
        $this->exitCode = $exitCode;
    }

    public function filterOutputLines(array $output, string $filter): array
    {
        if ($filter === null) {
            return $output;
        }
        $newArray = [];
        foreach ($output as $line) {
            $value = $filter($line);
            if ($value === false) {
                continue;
            }
            $newArray[] = $value;
        }
        return $newArray;
    }

    public function processCommand(array $args)
    {
        $cmd = [];
        $programName = array_shift($args);

        foreach ($args as $arg) {
            if (is_array($arg)) {

                foreach ($arg as $key => $value) {
                    $_c = '';
                    if (is_string($key)) {
                        $_c = "$key" . $this->optionGlue;
                    }
                    $cmd[] = $_c . $this->escapeshellarg($value);
                }
            } elseif (is_scalar($arg) && !is_bool($arg)) {
                $cmd[] = /*$this->escapeshellarg*/($arg);
            }
        }
//        dd("$programName " . implode(' ', $cmd));
        return "$programName " . implode(' ', $cmd);
    }

    public function escapeshellarg($arg): string
    {
        if(is_bool($arg)) {
            $arg = intval($arg);
        }
        if(is_int($arg)) {
            return strval($arg);
        }
        return escapeshellarg($arg);


            if (is_string($arg)) {
            $arg = escapeshellarg($arg);
        //} elseif (is_array($arg)) {

        } else {
            throw new \Exception('Bad command option type!');
        }
        return $arg;
    }
}
