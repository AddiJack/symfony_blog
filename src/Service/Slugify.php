<?php
/**
 * Created by PhpStorm.
 * User: addi
 * Date: 2019-05-29
 * Time: 16:17
 */

namespace App\Service;


class Slugify
{
    public function generate(string $input) : string
    {
        $input = preg_replace('/[-,!]/', "", $input);
        $input = iconv('UTF-8', 'ASCII//TRANSLIT', $input);
        $input = str_replace(" ", "-", $input);
        $input = trim($input);
        return $input;
    }
}