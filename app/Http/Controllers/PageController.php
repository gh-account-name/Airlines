<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Flight;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Nette\Utils\Arrays;
use PhpParser\Node\Expr\Cast\Array_;

class PageController extends Controller
{
    public function mainPage(){
        $popular_directions = Ticket::query()
            ->select('cities.title', 'cities.img', DB::raw('count(tickets.flight_id) as count_tickets'))
            ->join('flights', 'flights.id', 'tickets.flight_id')
            ->join('cities', 'cities.id','flights.to_city_id')
            ->groupBy('flights.to_city_id')
            ->orderByDesc('count_tickets')
            ->limit(4)
            ->get();
        return view('main', ['popular_directions'=>$popular_directions]);
    }

    public function authPage(){
        return view('user.auth');
    }

    public function regPage(){
        return view('user.reg');
    }

    public function citiesPage(){
        return view('admin.cities');
    }

    public function airplanesPage(){
        return view('admin.airplanes');
    }

    public function usersPage(){
        return view('admin.users');
    }

    public function airportsPage(){
        return view('admin.airports');
    }

    public function flightsPage(){
        return view('admin.flights');
    }

    public function flightsSearchResultPage(Request $request){
        $from_city = City::query()->where('title', mb_convert_case($request->from, MB_CASE_TITLE, 'UTF-8'))->first();
        $to_city = City::query()->where('title', mb_convert_case($request->to, MB_CASE_TITLE, 'UTF-8'))->first();
        if($from_city and $to_city){
            if($request->date){
               $flights = Flight::query()
                    ->where('from_city_id', $from_city->id)
                    ->where('to_city_id', $to_city->id)
                    ->where('dateFrom', $request->date)
                    ->where('status', 'готов')
                    ->with('airplane','from_city', 'to_city')
                    ->withCount('tickets')
                    ->get()
                    ->toArray(); 
            } else {
                $flights = Flight::query()
                    ->where('from_city_id', $from_city->id)
                    ->where('to_city_id', $to_city->id)
                    ->where('status', 'готов')
                    ->with('airplane','from_city', 'to_city')
                    ->withCount('tickets')
                    ->get()
                    ->toArray(); 
            }
            
        } else {
           $flights = []; 
        }
        return view('flightsSearchResult', ['flights'=>$flights]);
    }

    public function flightDetailsPage(Flight $flight){
        $occupiedSeats = [];
        $tickets = Ticket::query()->where('flight_id', $flight->id)->where('status', 'оформлен')->get();
        if ($tickets){
            foreach ($tickets as $ticket) {
                array_push($occupiedSeats, $ticket->seat);
            }
        }
        $flight = Flight::query()->where('id', $flight->id)->with('airplane','from_city', 'to_city')->first();
        return view('flightDetails', ['flight'=>$flight, 'occupiedSeats'=>$occupiedSeats]);
    }

    public function myTicketsPage(){
        $tickets = Ticket::query()->where('user_id', Auth::id())->get();
        $flights = [];
        foreach ($tickets as $ticket) {
            array_push($flights, Flight::query()->where('id', $ticket->flight_id)->with('airplane','from_city', 'to_city')->first());
        }
        return view('user.tickets', ['tickets'=>$tickets, 'flights'=>$flights]);
    }

    public function ticketsPage(){
        $tickets = Ticket::all();
        $flights = [];
        foreach ($tickets as $ticket) {
            array_push($flights, Flight::query()->where('id', $ticket->flight_id)->with('airplane','from_city', 'to_city')->first());
        }
        return view('admin.tickets', ['tickets'=>$tickets, 'flights'=>$flights]);
    }
}
