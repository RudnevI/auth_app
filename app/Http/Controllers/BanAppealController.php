<?php

namespace App\Http\Controllers;

use App\Models\BanAppeal;
use Illuminate\Http\Request;

class BanAppealController extends BaseCrudController
{

    public function getModel() {
        return BanAppeal::class;
    }

}
