<?php


namespace App\Http\Controllers\Voyager\ContentTypes;


use TCG\Voyager\Http\Controllers\ContentTypes\BaseType;

class Json extends BaseType
{
    /**
     * @return null|string
     */
    public function handle()
    {
        $value = $this->request->input($this->row->field);

        if (isset($this->options->null)) {
            if ($value == $this->options->null) {
                return null;
            } else if (!empty($value)) {
                return json_decode($value);
            }
        }
        if (!empty($value)) {
            return json_decode($value);
        }
        return null;
    }
}

