<?php


namespace App\FormFields;


use TCG\Voyager\FormFields\AbstractHandler;

class JsonFormField extends AbstractHandler
{
    protected $codename = 'json';
    protected $name = "JSON";

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('voyager::formfields.json', [
            'row' => $row,
            'options' => $options,
            'dataType' => $dataType,
            'dataTypeContent' => $dataTypeContent
        ]);
    }
}
