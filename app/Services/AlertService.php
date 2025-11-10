<?php
namespace App\Services;

class AlertService
{
    public static function updated($message = null)
    {
        notyf()->success($message ? $message : 'Updated successfully.');
    }

    public static function created($message = null)
    {
        notyf()->success($message ? $message : 'Created successfully.');
    }

    public static function deleted() : void
    {
        notyf()->success('Deleted Successfully');
    }

    public static function error($message) : void
    {
        notyf()->error($message ? $message : 'Something went wrong.');
    }
}
