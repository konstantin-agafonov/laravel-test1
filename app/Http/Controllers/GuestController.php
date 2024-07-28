<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'name' => ['required', 'max:50', 'min:2'],
            'surname' => ['required', 'max:50', 'min:2'],
            'phone' => ['required', 'max:20', 'min:3', 'unique:guests'],
            'email' => ['email', 'unique:guests'],
            'country' => ['max:2', 'min:2'],
        ]);

        $country_is_valid = false;
        $countries_data = Storage::json('CountryCodes.json');
        if (! empty($fields['country'])) {
            foreach ($countries_data as $country) {
                if ($fields['country'] === $country['code']) {
                    $country_is_valid = true;
                    break;
                }
            }
        } else {
            $country_is_valid = true;

            foreach ($countries_data as $country) {
                if (str_starts_with($fields['phone'], $country['dial_code'])) {
                    $fields['country'] = $country['code'];
                    break;
                }
            }
        }

        if (! $country_is_valid) {
            return [
                'message' => 'Country is not valid',
            ];
        }

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
            'name' => ['required', 'max:50', 'min:2'],
            'surname' => ['required', 'max:50', 'min:2'],
            'phone' => ['required', 'max:20', 'min:3', 'unique:guests'],
            'email' => ['email', 'unique:guests'],
            'country' => ['max:2', 'min:2'],
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
