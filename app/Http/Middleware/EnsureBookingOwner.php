<?php

namespace App\Http\Middleware;

use App\Models\Booking;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureBookingOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $booking = $request->route('booking');
        if ($booking instanceof Booking === false) {
            $booking = Booking::findOrFail($booking);
        }
        if ($request->user()->id !== $booking->user_id) {
            abort(403, 'Not your booking');
        }
        return $next($request);
    }
}
