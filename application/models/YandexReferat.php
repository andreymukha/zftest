<?php

class Application_Model_YandexReferat
{
    /**
     * Яндекс рефераты. Генерирует заголовок и тело реферата.
     * @author Andrey Mukha
     * @param mixed $category
     *  Доступные значения:
     *    - Конкретная категория из массива $arr
     *    - random (случайная категория из массива $arr)
     *    - all (выбор сразу всех категорий)
     *    - Массив из нескольких конкретных категорий
     * @return array категория, заголовок и тело реферата
     */
    public function yandex_referat($category = 'random'){

        //Массив всех категорий
        $arr = array(
            'astronomy',
            'geology',
            'gyroscope',
            'literature',
            'marketing',
            'mathematics',
            'music',
            'polit',
            'agrobiologia',
            'law',
            'psychology',
            'geography',
            'physics',
            'philosophy',
            'chemistry',
            'estetica',
        );

        //Рандомный выбор категории
        if($category == 'random'){
            $category = $arr[array_rand($arr)];
        }

        //Выбор всех категорий
        if($category == 'all'){
            $category = implode('+', $arr);
        }

        //Несколько определённых категорий в массиве
        if(is_array($category)){
            $category = implode('+', $category);
        }

        $content = file_get_contents('http://referats.yandex.ru/referats/?t='.$category);
        preg_match('!<div class="referats__text">(.*?)<\/p><\/div>!s', $content, $referat);
        preg_match('!<div>(.*?)</div>!u', $referat[0], $cat);
        preg_match('!«(.*?)»!', $referat[0], $title);
        preg_match('!<p>(.*)</p><\/div>!su', $referat[0], $body);
        return array(
            'cat' => preg_replace('![^А-Яа-я ]!u', '', trim($cat[0])),
            'title' => $title[1],
            'body' => str_replace("</p><p>", "\n\n", $body[1]),
        );
    }
}

