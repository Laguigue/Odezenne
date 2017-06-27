<?php

namespace App\Http\Controllers;

use App\Guest;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function createGuest(Request $request)
    {
        $guest = Guest::updateOrCreate(
            ['email' => $request->all()['email']],
            ['post_code' => $request->all()['postCode']]
        );
        $guest->touch();
    }

    public function verifyGuest(Request $request)
    {
        if (Guest::where('email', '=', $request->all()['email'])->exists()) {
            $guest_exists = true;
        } else {
            $guest_exists = false;
        }

        return response()->json(array('validLogin' => $guest_exists));
    }

    public function getGuests() {
        $guests = Guest::all();

        return response()->json($guests);
    }
}
