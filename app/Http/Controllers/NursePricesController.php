<?php

namespace App\Http\Controllers;

use App\Models\Nurse;
use Illuminate\Http\Request;

class NursePricesController extends Controller
{
    public function NursePricePer8Hours($pricePer8Hour)
    {
        $nurses = Nurse::where('pricePer8Hour', '<=', (int)$pricePer8Hour)
            ->get();
        return $nurses;
    }

    public function NursePricePer12Hours($pricePer12Hour)
    {
        $nurses = Nurse::where('pricePer12Hour', '<=', (int)$pricePer12Hour)
            ->get();
        return $nurses;
    }

    public function NursePricePer24Hours($pricePer24Hour)
    {
        $nurses = Nurse::where('pricePer24Hour', '<=', (int)$pricePer24Hour)
            ->get();
        return $nurses;
    }
}
