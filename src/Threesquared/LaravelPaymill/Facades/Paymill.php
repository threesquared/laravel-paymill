<?php namespace Threesquared\LaravelPaymill\Facades;

use Illuminate\Support\Facades\Facade;

class Paymill extends Facade {

    protected static function getFacadeAccessor() { return 'paymill'; }

}
