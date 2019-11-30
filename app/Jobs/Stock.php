<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\StoreQueue;

class Stock implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $stqueue;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(StoreQueue $store)
    {
        $this->stqueue = $store;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $res = StoreQueue::upStorage($this->stqueue);

        return $res;
    }
}
