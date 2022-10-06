<?php

class DataModel
{
    private $main;
    private $input;
    private $mainIndex = null;

    public function __construct(
        array $main,
        array $input
    )
    {
        $this->main = $main;
        $this->input = $input;
        $this->createMainIndex();
    }

    private function createMainIndex()
    {
        $this->mainIndex = [];
        foreach ($this->main as $v) {
            $this->mainIndex[(string)$v][gettype($v)] = $v;
        }
    }

    /**
     * @description Убедиться что в $main_array нету булевского значение true
     * @return bool
     */
    public function mainHasNoTrue(): bool
    {
        return !in_array(true, $this->main, true);
    }

    /**
     * @description Убедиться что во входящих параметрах есть булевское значение true (если оно было введено)
     * @return bool
     */
    public function inputHasTrue(): bool
    {
        return in_array(true, $this->input, true);
    }

    /**
     * @description Объединить массив и входящие параметры
     * @return array
     */
    public function joinData(): array
    {
        return array_merge($this->main, $this->input);
    }

    /**
     * @description Определить каких данных нету в $main_array но они есть во входящих параметрах
     * @return array
     */
    public function differenceInputNotMain(): array
    {
        $result = [];
        foreach ($this->input as $v) {
            if (!isset($this->mainIndex[(string)$v][gettype($v)])) {
                $result[] = $v;
            }
        }
        return $result;
    }

    /**
     * @description Определить какие данные есть в $main_array и во входящих параметрах
     * @return array
     */
    public function intersectionInputAndMain(): array
    {
        $result = [];
        foreach ($this->input as $v) {
            if (isset($this->mainIndex[(string)$v][gettype($v)])) {
                $result[] = $v;
            }
        }
        return $result;
    }

    /**
     * @description Все строковые значения в $main_array перевести в верхний регистр символов
     * @return array
     */
    public function upperCaseMain(): array
    {
        return array_map(function ($v) {
            if (is_string($v)) {
                return mb_strtoupper($v);
            }
            return $v;
        }, $this->main);
    }

    /**
     * @description Получить массив чисел из входящих параметров если были введены цифры
     * @return array
     */
    public function getInputNumbers(): array
    {
        return array_reduce($this->input, function ($carry, $item) {
            if (is_string($item) && preg_match("|^\d+$|", $item)) {
                $carry[] = intval($item);
            }
            return $carry;
        }, []);
    }

    /**
     * @description Отсортировать $main_array таким образом чтобы цифры стали первыми элементами массива
     * @return array
     */
    public function sortMainNubmersFirst(): array
    {
        usort($this->main, function ($a, $b) {
            $rateA = is_int($a) || is_float($a) ? -1 : 1;
            $rateB = is_int($b) || is_float($b) ? -1 : 1;
            return $rateA <=> $rateB;
        });
        return $this->main;
    }
}