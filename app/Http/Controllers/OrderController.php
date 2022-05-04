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
