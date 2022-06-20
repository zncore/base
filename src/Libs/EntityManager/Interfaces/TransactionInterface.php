<?php

namespace ZnCore\Base\Libs\EntityManager\Interfaces;

interface TransactionInterface
{

    public function beginTransaction();

    public function rollbackTransaction();

    public function commitTransaction();
}