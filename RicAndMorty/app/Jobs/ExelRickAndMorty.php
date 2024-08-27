<?php

namespace App\Jobs;

use App\Models\Episode;
use App\Models\Location;
use App\Models\Person;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExelRickAndMorty implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public Person $person,
        public Episode $episode,
        public Location $location,
    )
    {}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        dd($this->person);
    }
}
