<?php

namespace App\Jobs;

use App\Models\Show;
use App\Support\Import\ImportRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AddShow implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private string $imdbId)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @param ImportRepository $repository
     * @return void
     */
    public function handle(ImportRepository $repository): void
    {
        $data = $repository->getShow($this->imdbId);

        if ($data) {
            SaveShow::dispatch($data);
        }
    }
}
