<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Exception;

class AddToCart implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

     protected $user, $isbn, $qty;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $isbn, $qty)
    {
        $this->user = $user; 
        $this->isbn = $isbn;
        $this->qty = $qty;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $book = \App\Inventory::ask()->find($this->isbn);
<<<<<<< HEAD
        $book->addToCart($this->user->getRemoteAddr(), $this->user->KEY, $this->user->credentials, $this->qty);
=======
        $book->addToCart($this->user->getRemoteAddr(), $this->user->key, $this->user->credentials, $this->qty);
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
    }

        /**
     * The job failed to process
.     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        // Send user notification of failure, etc...

        $e = json_encode($exception);
        $myfile = fopen(base_path() . "/storage/addToCartFailure.txt", "a") or die("Unable to open file!");
        fwrite($myfile, $exception);
        fwrite($myfile, "\n\n failed here. -------------------------------\n");
        fclose($myfile);
    }

}
