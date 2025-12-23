<?php

namespace App\Imports;


use Maatwebsite\Excel\Concerns\ToModel;
use TCG\Voyager\Models\User;

class ExcelImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        /*return new User([
            'name'     => $row[0],
            'email'    => $row[1],
            'password' => Hash::make($row[2]),
        ]);*/
    }
}
