<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SearchHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $key_words  = ['cse', 'programming', 'laravel', 'orm', 'eloquent'];
        $ips        = ["22.100.215.72", "63.223.12.84", "141.193.198.228"];

        $random_word = $key_words[array_rand($key_words)];

		$now        = Carbon::now();
        $yesterday  = Carbon::yesterday();
		$last_week  = Carbon::now()->subWeek()->endOfWeek()->subDay(rand(1, 6))->addSeconds(rand(0, 86400));
		$last_month = Carbon::now()->subMonth()->endOfMonth()->subDay(rand(1, 30))->addSeconds(rand(0, 86400));

        $random_date_times  = [$now, $yesterday, $last_week, $last_month];
        $random_search_time = $random_date_times[array_rand($random_date_times)];

        return [
            'keyword'       => $random_word,
            'content'       => $random_word . ' ' . fake()->text(75),
            'user'          => $ips[array_rand($ips)],
            'search_time'   => $random_search_time,
        ];
    }
}
