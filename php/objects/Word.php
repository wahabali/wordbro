<?php
/**
 * Created by PhpStorm.
 * User: wts82020
 * Date: 05.08.2015
 * Time: 12:10
 */

namespace Objects;

class Word {
    public $word = "";
    public $meaning = "";
    public $partOfSpeech = "";
    public $gender = "";
    public $manual = 1;

    public function __construct(){}

    public static function constructWithParameters($word,$mean,$partOfSpeech,$gender,$manual)
    {
        $obj = new Word();
        $obj->word = $word;
        $obj->meaning = $mean;
        $obj->partOfSpeech = $partOfSpeech;
        $obj->gender = $gender;
        $obj->manual =$manual;
        return $obj;
    }
}