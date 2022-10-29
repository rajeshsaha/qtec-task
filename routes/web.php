<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchHistoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [SearchHistoryController::class, 'index'])->name('search');
Route::post('/history-filter', [SearchHistoryController::class, 'historyFilter'])->name('history_filter');

Route::get('/task2', function () {
    $text       = 'tadadattaetadadadafa';
    $pattern    = 'dada';
    $text_len   = strlen($text);
    $pat_len    = strlen($pattern);
    $found      = 0;

    // loop from index o to $text_len-$pat_len means no need to check above the subtract length coz no pattern match will found further
    for($i=0; $i <= $text_len-$pat_len; $i++) {
      	$mis_match = false; // let in this iteration, match
      
		// loop from 0 to pattern length
		for($j=0; $j < $pat_len; $j++) {

			// If any character does not match with text, set $mis_match 'true' and break from the inner loop
			// check from $i+$j=$i(text)+each index of pattern i.e text[$i+$j] = tada/ adad/ dada
			if($text[$i+$j] != $pattern[$j]) { // tada/ adad/ dada != dada
				$mis_match = true; // no match, so no need to check further in this iteration
				break;
			}
		}

		// no mismatch for pattern in terms of current $i; so one match found and increase found value
		if(!$mis_match) {
			$found++;
		} 
    }

    echo "Pattern ($pattern) appears in text ($text): $found times";
});