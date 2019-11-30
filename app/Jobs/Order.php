<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\OrderQueue;
use App\Http\Controllers\Admin\OrderQueueController;


class Order implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $queue;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(OrderQueue $order)
    {
        $this->queue = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $orderHanle = new OrderQueue();
        // $orderHanle->orderQueueHandle();
        // $this->queue->orderQueueHandle();

        //
    }
}
