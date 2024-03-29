<?php

namespace ZnCore\Base\Helpers;

use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Legacy\Yii\Helpers\Html;
use ZnCore\Base\Legacy\Yii\Helpers\Url;

class HtmlHelper
{

    public static function getTagContent(string $string, string $tagname)
    {
        $pattern = "/<$tagname ?.*>(.*)<\/$tagname>/";
        preg_match($pattern, $string, $matches);
        return $matches[1];
    }

    public static function generateDataList(string $id, array $options, string $fieldName)
    {
        $optionsHtml = '';
        foreach ($options as $option) {
            $value = $option[$fieldName];
            $optionsHtml .= Html::tag('option', '', ['value' => $value]);
        }
        return Html::tag('datalist', $optionsHtml, ['id' => $id]);
    }

    public static function generateBase64Content(string $content, string $mimeType): string
    {
        $base64Content = base64_encode($content);
        return "data:{$mimeType};base64, {$base64Content}";
    }

    public static function sortByField(string $label, string $fieldName, string $baseUrl, array $getParams = []): string
    {
        $sortParams = ArrayHelper::getValue($getParams, 'sort', []);
        $sortParams = self::normalizeOrderBy($sortParams);
        $direction = ArrayHelper::getValue($sortParams, $fieldName);
        if($direction) {
            $arrow = $direction == SORT_ASC ? '<i class="fas fa-sort-alpha-down"></i>' : '<i class="fas fa-sort-alpha-up"></i>';
            $label .=  ' ' . $arrow;
        }
        $invertDirection = $direction == SORT_ASC ? SORT_DESC : SORT_ASC;
        $sortParamsString = self::sortParamsToString([$fieldName => $invertDirection]);
        $getParams['sort'] = $sortParamsString;
        $uri = $baseUrl . '?' . http_build_query($getParams);
        return Html::a($label, $uri);
    }

    public static function sortParamsToString(array $sortParams): string
    {
        $resultSortParams = [];
        foreach ($sortParams as $fieldName => $direction) {
            $itemPrefix = $direction == SORT_ASC ? '' : '-';
            $resultSortParams[] = $itemPrefix . $fieldName;
        }
        return implode(',', $resultSortParams);
    }

    public static function normalizeOrderBy($columns): array
    {
        if (is_array($columns)) {
            return $columns;
        }

        $columns = preg_split('/\s*,\s*/', trim($columns), -1, PREG_SPLIT_NO_EMPTY);
        $result = [];
        foreach ($columns as $column) {
            if($column[0] == '-') {
                $column = trim($column, '-');
                $result[$column] = SORT_DESC;
            } else {
                $result[$column] = SORT_ASC;
            }
        }
        return $result;
    }
}
