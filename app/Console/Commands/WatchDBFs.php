<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\ResourceWatcher\Tracker;
use App\ResourceWatcher\Watcher;
use Illuminate\Filesystem\Filesystem;
use App\ResourceWatcher\Event as DBFEvent;
use App\Helpers\StringHelper;
use Config;

class WatchDBFs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:watch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'File watcher for DBFs';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->lock_file = base_path().'/watch.lock';
        $this->openLock();
    }

    public function openLock(){
        $this->fp = fopen($this->lock_file,'a') or die('cannot open');
        return $this;
    }

    /** 
     * Execute the console command.
     *
     * @return int
     */

     public function handle()
    {

        $wouldBlock;

        if (!flock($this->fp, LOCK_EX|LOCK_NB, $wouldblock)) {
            if ($wouldblock) {
                // another process holds the lock
                echo 'Watcher Already Running!';
            }
            else {
                // couldn't lock for another reason, e.g. no such file
                file_put_contents('watch.lock',"locked");
                $this->openLock();
                echo 'Watcher Ran into an Error at the Beginning! Trying to Create Lock File now...';
                return new WatchDBFs();
                
            }
        }
        else {
            // lock obtained
            return $this->runWatcher();
        }

    }

    public function runWatcher()
    {

    /*
    |--------------------------------------------------------------------------
    | Resource Watcher Dependencies
    |--------------------------------------------------------------------------
    |
    | Create a new instance of Illuminate's Filesystem class and of the
    | Resource Watcher's Tracker class. These are dependencies of the Resource
    | Watcher and will be injected into the constructor.
    |
    */
    $files = new Filesystem();

    $tracker = new Tracker();

    /*
    |--------------------------------------------------------------------------
    | Instantiate Resource Watcher
    |--------------------------------------------------------------------------
    |
    | Create a new instance of the Resource Watcher so we can watch resources
    | for any changes.
    |
    */

    $watcher = new Watcher($tracker, $files);

    /*
    |--------------------------------------------------------------------------
    | Watch For Changes
    |--------------------------------------------------------------------------
    |
    | Watch for changes to a resource. The resource given does not need to
    | exist to begin watching.
    |
    */

    $listener = $watcher->watch(env('WATCH_THIS'));

    /*
    |--------------------------------------------------------------------------
    | Anything Listener
    |--------------------------------------------------------------------------
    |
    | Listen for anything.
    |
    */

    $listener->onAnything(function ($event, $resource, $path) {
        switch ($event->getCode()) {
            case DBFEvent::RESOURCE_DELETED:
                echo "{$path} was deleted (from anything listener).".PHP_EOL;
                break;
            case DBFEvent::RESOURCE_MODIFIED:
                echo "{$path} was modified (from anything listener).".PHP_EOL;
                $file = StringHelper::dbfPathToModel($path);
                echo $this->fileWasChanged($file);
                unset($file);
                break;
            case DBFEvent::RESOURCE_CREATED:
                echo "{$path} was created (from anything listener).".PHP_EOL;
                break;
        }
    });

    /*
    |--------------------------------------------------------------------------
    | Start Watching
    |--------------------------------------------------------------------------
    |
    | Now that all the listeners are bound we can start watching. By default
    | the watcher will poll for changes every second. You can adjust this by
    | passing in an optional first parameter. The interval is given in
    | microseconds. 1,000,000 microseconds is 1 second.
    |
    | By default the watch will continue until such time that it's aborted from
    | the terminal. To set a timeout pass in the number of microseconds before
    | the watch will abort as the second parameter.
    |
    */

    $watcher->start();
    }

    public function fileWasChanged($file_name){
        $opt = new \stdclass;
        $opt->name = $file_name;
        $opt->seed = true;

        $watch = Config::get('cp')['watch_for_changes'];

        if(in_array($opt->name, $watch)){
            $table = (new $opt->name)->getTable();
            //return\Artisan::call("db:seed true ".$table);
            $command = "php artisan db:seed true " . $table;
            exec( $command, $output, $status );
            return 'MYSQL was updated for ' . $opt->name . "\n" . json_encode($output) . "\n". $status;
        }else{
            return 'MYSQL was not updated because I am not watching for changes in ' . $opt->name;
        }
    }
}
