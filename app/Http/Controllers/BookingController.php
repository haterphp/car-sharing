<?php

namespace App\Http\Controllers;

use App\Exceptions\BookingAlreadyClosedException;
use App\Http\Requests\BookingStoreRequest;
use App\Http\Resources\BookingIndexResource;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class BookingController extends Controller
{
    public function active()
    {
        $bookings = BookingIndexResource::collection(Auth::user()
            ->bookings()
            ->with('cars')
            ->where(['status' => 1])
            ->get());

        return response()->json([
            'data' => [
                'items' => $bookings
            ]
        ],200);
    }

    public function store(BookingStoreRequest $request)
    {
        $isset_user = User::isset_user($request->client['phone']);
        $random_pass = Str::random(10);
        $user = ($isset_user)
            ? User::where(['phone' => $request->client['phone']])->first()
            : User::create(['password' => $random_pass]+$request->client);

        $code = Booking::generate_code();

        $booking = Booking::create(
            [
                'user_id' => $user->id,
                'status' => 1,
                'code' => $code
            ]
            +$request->only('start_date', 'end_date')
        );

        collect($request->cars)->each(fn($item) => $booking->booking_cars()->create(['car_id' => $item]));

        $body = [
            'data' => collect([
                'code' => $booking->code
            ])
        ];

        if(!$isset_user)
            $body['data']['user'] = [
                'password' => $random_pass
            ];

        return response()->json($body, 201);
    }

    public function view(Booking $booking)
    {
        try {
            if(!Auth::user()->bookings()->pluck('id')->contains($booking->id))
                throw new AccessDeniedException;
        }
        catch(AccessDeniedException $exception){
            throw new HttpResponseException(
                response()->json([
                'error' => [
                    'code' => 403,
                    'message' => 'Access denied'
                ]
            ], 403));
        }

        $b = (object) array_merge($booking->toArray(), ['cars' => $booking->cars]);

        return response()->json([
            'data' => BookingIndexResource::make($b)
        ], 200);
    }

    public function history()
    {
        $bookings = BookingIndexResource::collection(Auth::user()
            ->bookings()
            ->with('cars')
            ->where(['status' => 2])
            ->get());

        return response()->json([
            'data' => [
                'items' => $bookings
            ]
        ],200);
    }

    public function close(Booking $booking)
    {
        try {
            if(!Auth::user()
                ->bookings()
                ->where(['status' => 1])
                ->pluck('id')
                ->contains($booking->id))
                throw new AccessDeniedException;
        }
        catch(AccessDeniedException $exception){
            throw new HttpResponseException(
                response()->json([
                    'error' => [
                        'code' => 403,
                        'message' => 'Access denied'
                    ]
                ], 403));
        }

        $booking->changeStatus();

        return response()->json([
            'data' => [
                'message' => 'Booking closed'
            ]
        ], 200);
    }
}
