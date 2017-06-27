<?php

namespace App\Http\Controllers;

use App\Guest;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function createGuest(Request $request) {
        Guest::firstOrCreate(['email' => $request->all()['email']]);
    }
}
