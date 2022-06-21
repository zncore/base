<?php

namespace ZnCore\Base\Libs\QueryFilter\Helpers;

use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\Entity\Helpers\EntityHelper;
use ZnCore\Base\Libs\Query\Entities\Query;
use ZnCore\Base\Libs\Query\Entities\Where;
use ZnCore\Base\Libs\Validation\Exceptions\UnprocessibleEntityException;
use ZnCore\Base\Libs\Validation\Helpers\ValidationHelper;
use ZnCore\Base\Libs\QueryFilter\Exceptions\BadFilterValidateException;
use ZnCore\Base\Libs\QueryFilter\Interfaces\DefaultSortInterface;
use ZnCore\Base\Libs\QueryFilter\Interfaces\IgnoreAttributesInterface;

class FilterModelHelper
{

    public static function validate(object $filterModel)
    {
        try {
            ValidationHelper::validateEntity($filterModel);
        } catch (UnprocessibleEntityException $e) {
            $exception = new BadFilterValidateException();
            $exception->setErrorCollection($e->getErrorCollection());
            throw new $exception;
        }
    }

    public static function forgeCondition(Query $query, object $filterModel, array $attributesOnly)
    {
        $params = EntityHelper::toArrayForTablize($filterModel);
        if ($filterModel instanceof IgnoreAttributesInterface) {
            $filterParams = $filterModel->ignoreAttributesFromCondition();
            foreach ($params as $key => $value) {
                if (in_array($key, $filterParams)) {
                    unset($params[$key]);
                }
            }
        } else {
            $params = ArrayHelper::extractByKeys($params, $attributesOnly);
        }
        foreach ($params as $paramsName => $paramValue) {
            if ($paramValue !== null) {
                $query->whereNew(new Where($paramsName, $paramValue));
            }
        }
    }

    public static function forgeOrder(Query $query, object $filterModel)
    {
        $sort = $query->getParam(Query::ORDER);
        if (empty($sort) && $filterModel instanceof DefaultSortInterface) {
            $sort = $filterModel->defaultSort();
            $query->orderBy($sort);
        }
    }
}