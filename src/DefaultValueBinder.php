<?php

namespace WintechLaravel\Excel;

use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder as PhpSpreadsheetDefaultValueBinder;

class DefaultValueBinder extends PhpSpreadsheetDefaultValueBinder
{
    public function bindValue(Cell $cell, $value)
    {
        if (is_array($value)) {
            $value = \json_encode($value);
        }

        return parent::bindValue($cell, $value);
    }
}
