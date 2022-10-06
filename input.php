<?php

$input_array = $argv;
array_shift($input_array);
return typeCastArray($input_array);

function typeCastArray(array $arr): array
{
    return array_map(function ($a) {
        switch ($a) {
            case 'true':
                return true;
            case 'false':
                return false;
            default:
                return $a;
        }
    }, $arr);
}