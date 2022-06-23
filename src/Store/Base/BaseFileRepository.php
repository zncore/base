<?php

namespace ZnCore\Base\Store\Base;

use ZnCore\Contract\Common\Exceptions\NotImplementedMethodException;
use ZnCore\Base\DotEnv\Domain\Libs\DotEnv;
use ZnCore\Base\FileSystem\Helpers\FilePathHelper;
use ZnCore\Base\Store\StoreFile;
use ZnCore\Domain\EntityManager\Interfaces\EntityManagerInterface;
use ZnCore\Domain\Repository\Interfaces\RepositoryInterface;
use ZnCore\Domain\EntityManager\Traits\EntityManagerAwareTrait;

abstract class BaseFileRepository implements RepositoryInterface
{

    use EntityManagerAwareTrait;

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function tableName(): string
    {
        throw new NotImplementedMethodException('Not Implemented Method "tableName"');
    }

    public function directory(): string
    {
        return DotEnv::get('FILE_DB_DIRECTORY');
    }

    public function fileExt(): string
    {
        return 'php';
    }

    public function fileName(): string
    {
        $tableName = $this->tableName();
        $root = FilePathHelper::rootPath();
        $directory = $this->directory();
        $ext = $this->fileExt();
        $path = "$root/$directory/$tableName.$ext";
        return $path;
    }

    protected function getItems(): array
    {
        // todo: cache data
        $store = new StoreFile($this->fileName());
        return $store->load() ?: [];
    }

    protected function setItems(array $items)
    {
        $store = new StoreFile($this->fileName());
        return $store->save($items);
    }
}
