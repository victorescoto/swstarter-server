<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class CalculateStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statistics:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Read the information of the latest requests and calculate the statistics';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $redis = Redis::connection();
        $requestKeys = $redis->keys('request:*');

        if (count($requestKeys) < 5) {
            $this->info('Not enough requests to calculate statistics');
            return 0;
        }

        $prefix = config('database.redis.options.prefix');
        $requests = [];

        $this->info('Reading information from the latest requests');
        foreach($requestKeys as &$key) {
            $key = Str::of($key)->replace($prefix, '');
            array_push($requests, json_decode($redis->get($key)));
        }

        // Sorting asc by date
        usort($requests, fn ($a, $b) => $a->date <=> $b->date);

        $this->info('Calculating statistics');
        $executionTimes = data_get($requests, '*.executionTime');
        $dates = data_get($requests, '*.date');

        $statistics = [
            'searches' => data_get($requests, '*.path'),
            'fasterRequest' => min($executionTimes),
            'slowestRequest' => max($executionTimes),
            'averageRequestTime' => array_sum($executionTimes) / count($executionTimes),
            'requestsDateInterval' => [
                'from' => min($dates),
                'to' => max($dates),
            ],
            'totalRequests' => count($requests),
            'successes' => count(array_filter(data_get($requests, '*.isSuccessful'))),
            'resultsFound' => array_sum(data_get($requests, '*.resultsFound')),
            'resultsReturned' => array_sum(data_get($requests, '*.resultsReturned')),
        ];

        $this->info('Saving the results');
        $redis->set('statistics', json_encode($statistics));

        $redis->del($requestKeys);

        $this->info('Job finished');

        return 0;
    }
}
