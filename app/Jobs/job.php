<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\OrderQueue;
use App\Http\Controllers\Admin\OrderQueueList;


class job implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $orqueue;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(OrderQueue $order)
    {
        $this->orqueue = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $this->hahah();
        // \Log::info('orqeue1111:'.json_encode($this->orqueue));
        // OrderQueue::one($this->orqueue);
        //
    }

  


   
}
