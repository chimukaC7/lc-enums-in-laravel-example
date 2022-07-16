<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //GLOBAL HELPERS
        //Helpers
        Carbon::now();//gives date and time
        Carbon::today();//same thing as now() but time is set to zero
        now();
        today();

        Carbon::tomorrow();
        Carbon::yesterday();

        //CARBON PARSE
        //Instantiation
        $yesterday = Carbon::yesterday();
        $date = Carbon::parse($yesterday);

        Carbon::parse('Thursday this week');
        Carbon::parse('first day of this month');
        Carbon::parse('2020-03-04 12:34:10', 'Africa/Lusaka');//this is the most practical way, to pass it a string, include the time zone to override the one in the config
        Carbon::parse('12/06/2020');//this is the most practical way, to pass it a string
        Carbon::canBeCreatedFromFormat('d/m/y', '12/06./2020');

        //GETTERS
        //allow you to access certain properties about the date
        $date = Carbon::now();
        $date->year;
        $date->month;//number
        $date->dayOfWeek;//number
        $date->englishDayOfWeek;//give a description
        $date->englishMonth;//gives a description
        $date->tzName;//current time zone
        $date->weekOfYear;
        $date->daysInMonth;
        $date->dst;//day light savings time

        //STRING FORMATING
        //Formating
        $date->toFormattedDateString();
        $date->format('M d Y h:i:sA');

        //COMPARISONS
        //Comparisons (Operators)
        //you can make use of operators to compare dates
        $now = Carbon::now();
        $yesterday = Carbon::yesterday();
        $tomorrow = Carbon::tomorrow();

        $now > $yesterday;//true
        $now > $tomorrow;//false
        $now->greaterThan($yesterday);//making use of methods
        $now->gt($yesterday);//shorter form
        $now->greaterThan($tomorrow);

        //Comparisons (between dates)
        $now = Carbon::now();
        $yesterday = Carbon::yesterday();
        $tomorrow = Carbon::tomorrow();

        $now->between($yesterday,$tomorrow);//true
        $now->betweenIncluded($yesterday,$tomorrow);//being more explicit about the range

        //Comparisions (isX methods)
        $now = Carbon::now();

        $now->isWeekday();
        $now->isWeekend();
        $now->isTuesday();
        $now->isFuture();
        $now->isPast();

        //MODIFIERS
        //which perform helpful modifications to the current carbon instance
        $date = Carbon::now();
        $date->startOfHour();
        $date->endOfHour();
        $date->firstOfMonth(Carbon::MONDAY);
        $date->nthOfMonth(2,Carbon::MONDAY);

        //Addition and Subtraction
        $now = Carbon::now();
        $now->addMonth(2);
        $now->subMonth(1);

        //DIFF FOR HUMANS
        //Diff for Humans
        //give a human readable form for the difference of two dates
        $dayInPast = Carbon::yesterday();
        $dayInPast->diffForHumans();

        $dayInFuture = Carbon::now()->addDays(3);
        $dayInFuture->diffForHumans();

        //other convenience methods to format in different ways
        $dayInPast->shortAbsoluteDiffForHumans();
        $dayInPast->longAbsoluteDiffForHumans();//drops the ago key word
        $dayInPast->shortRelativeDiffForHumans();
        $dayInPast->diffForHumans(['options'=> Carbon::ONE_DAY_WORDS]);//says yester

        /*
         *Carbon extends the base DateTime class, so you can use the diff method, which returns a DateInterval.
         * Then you can use the format method on that:
         * */
        Carbon::createFromDate(1991, 7, 19)->diff(Carbon::now())->format('%y years, %m months and %d days');
        // => "23 years, 6 months and 26 days

        //How to query between two dates using Laravel and Eloquent?
        //The whereBetween method verifies that a column's value is between two values.

        //--------------------------------------------------------------------------------------------------------------
        $from = date('2018-01-01');
        $to = date('2018-05-02');

        //Since you are fetching based on a single column value you can simplify your query likewise:
        Reservation::whereBetween('reservation_from', [$from, $to])->get();
        //--------------------------------------------------------------------------------------------------------------

        //--------------------------------------------------------------------------------------------------------------
        Reservation::all()->filter(function($item) {
            if (Carbon::now()->between($item->from, $item->to)) {
                return $item;
            }
        });
        //--------------------------------------------------------------------------------------------------------------

        //--------------------------------------------------------------------------------------------------------------
        $now = date('Y-m-d');
        $reservations = Reservation::where('reservation_from', '>=', $now)
            ->where('reservation_from', '<=', $to)
            ->get();
        //--------------------------------------------------------------------------------------------------------------

        //--------------------------------------------------------------------------------------------------------------
        $articles = Articles::where("created_at",">", Carbon::now()->subMonths(3))->get();
        //--------------------------------------------------------------------------------------------------------------

        //--------------------------------------------------------------------------------------------------------------
        $from = Carbon::parse();
        $to = Carbon::parse();
        $from = Carbon::parse('2018-01-01')->toDateTimeString();
        //Include all the results that fall in $to date as well
        $to = Carbon::parse('2018-05-02')
            ->addHours(23)
            ->addMinutes(59)
            ->addSeconds(59)
            ->toDateTimeString();
        //Or $to can also be like so
        $to = Carbon::parse('2018-05-02')
            ->addHours(24)
            ->toDateTimeString();
        Reservation::whereBetween('reservation_from', [$from, $to])->get();
        //--------------------------------------------------------------------------------------------------------------


        //To get the last 10 days record from now
        $lastTenDaysRecord = ModelName::whereDateBetween('created_at',(new Carbon)->subDays(10)->startOfDay()->toDateString(),(new Carbon)->now()->endOfDay()->toDateString() )->get();

        //To get the last 30 days record from now
        $lastThirtyDaysRecord = ModelName::whereDateBetween('created_at',(new Carbon)->subDays(30)->startOfDay()->toDateString(),(new Carbon)->now()->endOfDay()->toDateString() )->get();


        //--------------------------------------------------------------------------------------------------------------
        $startDate = Carbon::createFromFormat('d/m/Y', '01/01/2021');
        $endDate = Carbon::createFromFormat('d/m/Y', '06/01/2021');

        $users = User::select('id', 'name', 'email', 'created_at')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();
        //--------------------------------------------------------------------------------------------------------------

        //--------------------------------------------------------------------------------------------------------------
        $startDate = Carbon::createFromFormat('d/m/Y', '01/01/2021');
        $endDate = Carbon::createFromFormat('d/m/Y', '06/01/2021');

        $users = User::select('id', 'name', 'email', 'created_at')
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<=', $endDate)
            ->get();
        //--------------------------------------------------------------------------------------------------------------

        //--------------------------------------------------------------------------------------------------------------
        $startDate = '01/01/2021';
        $endDate = '06/01/2021';

        $users = User::select('id', 'name', 'email', 'paid_date')
            ->whereDate('paid_date', '>=', $startDate)
            ->whereDate('paid_date', '<=', $endDate)
            ->get();
        //--------------------------------------------------------------------------------------------------------------

        //--------------------------------------------------------------------------------------------------------------
        $dt = Carbon::create(2012, 1, 31, 12, 0, 0);
        $dt->isWeekday();
        $dt->isWeekend();
        $dt->isYesterday();
        $dt->isToday();
        $dt->isTomorrow();
        $dt->isFuture();
        $dt->isPast();
        $dt->isLeapYear();
        $dt->isSameDay(Carbon::now());
        //--------------------------------------------------------------------------------------------------------------
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrderRequest  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
