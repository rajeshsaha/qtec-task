<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SearchHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SearchHistoryController extends Controller
{
	/**
	 * all search history records
	 *
	 * @return void
	 */
	public function index() {
		$histories 	= SearchHistory::orderBy('id', 'desc')->get();
		$keywords 	= SearchHistory::select('keyword', DB::raw('COUNT(keyword) as found'))
						->groupBy('keyword')->get();

		$users 		= $histories->unique('user');

		return view('history.index', compact('histories', 'keywords', 'users'));
	}

	/**
	 * filter search histories by criteria
	 *
	 * @param Request $request
	 * @return void
	 */
	public function historyFilter(Request $request)
    {
		$input = $request->all();

		$keywords 		= $request->input('selected_keywords');
		$users 			= $request->input('selected_users');
		$time_ranges 	= $request->input('selected_time_range');
		
		$date_filters = [];
		if($request->filled('date_from')) {
			$date_filters['date_from'] 	= $request->input('date_from');
		}

		if($request->filled('date_to')) {
			$date_filters['date_to'] 	= $request->input('date_to');
		}

		$history_ids = SearchHistory::
			when($keywords, function ($query, $keywords) {
				$query->orWhereIn('keyword', $keywords);
			})
			->when($users, function ($query, $users) {
				$query->orWhereIn('user', $users);
			})
			->when($date_filters, function ($query, $date_filters) {
				if( array_key_exists('date_from', $date_filters) && array_key_exists('date_to', $date_filters) ) {
					$query->orWhereBetween('search_time', [$date_filters['date_from'], $date_filters['date_to']]);
				} else if(array_key_exists('date_from', $date_filters)) {
					$query->orWhereDate('search_time', '>=', $date_filters['date_from']);
				} else {
					$query->orWhereDate('search_time', '<=', $date_filters['date_to']);
				}
			})
			->when($time_ranges, function ($query, $time_ranges) {
				if(in_array('yesterday', $time_ranges)) {
					$query->oRWhereDate('search_time', Carbon::yesterday()->toDateString());
				} 
				if(in_array('last_week', $time_ranges)) {
					$query->orWhereBetween('search_time', [
						Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()
					]);
				} 
				if(in_array('last_month', $time_ranges)) {
					$query->orWhereBetween('search_time', [ 
						Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()
					]);
				}
			})
			->pluck('id');

        return response()->json(['history_ids' => $history_ids]);
    }
}
