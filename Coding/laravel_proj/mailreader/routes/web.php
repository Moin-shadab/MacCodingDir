<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/fetch-mails', [MailController::class, 'fetchEmails']);
Route::get('/emails/{id}', [MailController::class, 'showEmail']);
// use App\Http\Controllers\MailController;

// Route::get('/fetch-mails', [MailController::class, 'fetchEmails']);