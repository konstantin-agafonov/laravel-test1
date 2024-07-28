<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Guest::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'name'      => ['required', 'max:50', 'min:2'],
            'surname'   => ['required', 'max:50', 'min:2'],
            'phone'     => ['required', 'max:20', 'min:3','unique:guests'],
            'email'     => ['email','unique:guests'],
            'country'   => ['max:2', 'min:2'],
        ]);

        $guest = Guest::create($fields);

        return [
            'guest' => $guest,
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Guest $guest)
    {
        return [
            'guest' => $guest,
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guest $guest)
    {
        $fields = $request->validate([
            'name'      => ['required', 'max:50', 'min:2'],
            'surname'   => ['required', 'max:50', 'min:2'],
            'phone'     => ['required', 'max:20', 'min:3'],
            'email'     => ['email'],
            'country'   => ['max:2', 'min:2'],
        ]);

        $guest->update($fields);

        return [
            'guest' => $guest,
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guest $guest)
    {
        $guest->delete();

        return [
            'message' => 'Guest deleted successfully',
        ];
    }
}
