<?php

namespace App\Exports;

use App\Models\PartnerSurvey;
use Maatwebsite\Excel\Concerns\FromCollection;

class PartnerSurveysExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return PartnerSurvey::all();
    }
}
