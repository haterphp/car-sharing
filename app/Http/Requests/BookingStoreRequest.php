<?php

namespace App\Http\Requests;

use App\Models\BookingCar;
use Illuminate\Foundation\Http\FormRequest;

class BookingStoreRequest extends ApiRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $cars = BookingCar::with('booking')->get();

        return [
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
            'cars' => 'required|array',
            'cars.*' => ['integer', 'exists:cars,id', function($attr, $value, $fail) use ($cars){
                if($cars->pluck('car_id')->contains($value))
                    if($cars->keyBy('car_id')[$value]['booking']['status'] == 1)
                        $fail("This car is now booked");
            }],
            'client' => 'required',
            'client.first_name' => 'required|string',
            'client.last_name' => 'required|string',
            'client.patronymic' => 'string',
            'client.phone' => 'required|string|size:11',
            'client.birth_date' => 'required|date|before:today',
            'client.passport_series' => 'required|string|size:4',
            'client.passport_number' => 'required|string|size:6',
        ];
    }
}

