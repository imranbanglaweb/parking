<?php


namespace App\FormFields;


use TCG\Voyager\FormFields\AbstractHandler;

class DateTimePickerFormField extends AbstractHandler
{
    protected $codename = 'date_time';
    protected $name = "Date Time";

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('voyager::formfields.date_time', [
            'row' => $row,
            'options' => $options,
            'dataType' => $dataType,
            'dataTypeContent' => $dataTypeContent
        ]);
    }
}