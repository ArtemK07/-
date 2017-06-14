<?php

Route::get('/', function () {
    return view('home');
});

Route::get('allTransfers', array('as' => 'allTransfers', 'uses' => 'HomeController@getAllTransfers'));
Route::get('getAllTransfers', array('as' => 'getAllTransfers', 'uses' => 'HomeController@showAllTransfers'));

Route::get('delete/{id}/date/{date}', 'HomeController@delete')->where(['id' => '[0-9]+', 'date' => '[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])']);
Route::post('edit/{id}/date/{date}', 'HomeController@edit')->where(['id' => '[0-9]+'])->where(['id' => '[0-9]+', 'date' => '[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])']);




