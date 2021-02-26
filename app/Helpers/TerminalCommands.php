<?php namespace App\Helpers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth, Session;
use App\Helpers\DatabaseManager;
use App\Dbf;
use App\Command;

class TerminalCommands
{
   
	public static function exec($command, $opt = [])
    {
			switch($command){
                case "GIT_ALL_COMMANDS":
                     $commandToExecute = "GIT_ALL_COMMANDS";

                    break;
				case "ADD_COMMIT_PUSH":
					$commandToExecute = 'git add --all && git commit -m "'.$opt->message.'" && git push';
					break;
				case "GIT_ADD_ALL":
					$commandToExecute = 'git add --all 2>&1';
					break;
				case "GIT_PULL": //ok
					$commandToExecute = 'git pull';
					break;
				case "GIT_STATUS"://ok
					$commandToExecute = 'git status';
					break;
				case "GIT_COMMIT":
					$commandToExecute = 'git commit -m "'.$opt->message.'"';
					break;
				case "GIT_PUSH":
					$commandToExecute = 'git push';
					break;
                case "GIT_RESET":
                    $commandToExecute = 'git reset --hard origin/master';
                    break;
                    
                case "REBUILD_AUTOLOAD":
                    $commandToExecute = "composer dump-autoload";
                    break;
                case "COMPOSER_UPDATE":
                    $commandToExecute = 'composer update';
                case "COMPOSER_INSTALL":
                    $commandToExecute = 'composer install';
                    break;
                case "EXPORT_DBF_TO_XML":
                    $commandToExecute = "cd " . \Config::get('cp')["datarootpath"] . " && vfp " . $opt["table"] .".prg";
                    break;
                case "RESTART_QUE":
                    $commandToExecute = "php artisan queue:restart";
                    break;

                case "START_QUE":
                    $commandToExecute = "php artisan queue:work";
                    break;

                case "DB_MIGRATE":
                case "MIGRATE":
                    $commandToExecute = "php artisan migrate";
                    break;

                case 'DELETE_DBF_UPDATES':
                    $path = base_path() . DIRECTORY_SEPARATOR . "dbf_changes.json";
                    if(file_exists($path)){
                      unlink($path);
                    }

                    $commandToExecute = '';
                    return true;
                    break;
                
                case "SCHEDULE":
                    $commandToExecute = "php artisan schedule:run";
                    return \Artisan::call('schedule:run');
                    break;

                case "OPTIMIZE":
                    $commandToExecute = "php artisan optimize";
                    break;

                case "CLEAR_SERVER_ERRORS":
                    $commandToExecute = "del " . storage_path() . "\logs\laravel.log";
                    break;

                case "CACHE_FLUSH":
                    \Cache::flush();
                    $response = ["message"=>"Cache table flushed", "command"=>"FLUSH CACHE", "options"=> [] ];
					return view('application', ["response"=>$response]);
                    break;

                case "PASSPORT_INIT":
                    $commandToExecute = "php artisan passport:install";
                    break;

				default:
                    if (is_array($opt)) {
                        $opt = implode(" ", $opt);
                    }
					$response = ["message"=>"Something not right with that!", "command"=>$command, "options"=> $opt ];

					return view('application', ["response"=>$response]);
			}
			
			return static::terminal($commandToExecute, $opt);

	}
	
	/**
    Method to execute a command in the terminal
    Uses :
     
    1. system
    2. passthru
    3. exec
    4. shell_exec
 
*/
public static function terminal($command, $opt = false)
{

        $status = false;
        $alloutput = [];
        if(!$opt){
            $opt = new \stdclass;
            $opt->message = "update";
        }else if(!$opt->message){
            $opt->message = "update";
        }

        if($command === "GIT_ALL_COMMANDS"){

            $commandToExecute = 'git add --all && git commit -m "'.$opt->message.'" && git pull && git push && composer update';
                //https://stackoverflow.com/questions/8562544/executing-git-commands-via-php
            
            //$commands = explode("&&", $commandToExecute);
            //dd($commands);

            exec( $command, $output, $status );
            array_push($alloutput, $output);

            if (is_null($output))
            {   // B: does not exist
                // do whatever you want with the stderr output here
                $status = 500;
            }

        }else{
      
            $commands = explode("&&", $command);
            foreach ($commands as $c) {
                $alloutput[] = trim($c);
                
                exec( 'cd ' . base_path() . ' && ' . trim($c) . " 2>&1", $output, $status );
               array_push($alloutput, $output);
                $alloutput[] = "STATUS CODE: " . $status;

                    exec("pwd", $output, $status);
                    $alloutput[] = "EXECUTED AT PATH: ";
                    array_push($alloutput, $output);

                if($status !== 0){
                    $alloutput[] = "INTERRUPTED";
                    break;
                }
                $output = [];
            }
      
            
           
        }

        $alloutput = array_flatten($alloutput);
    return array('output' => $alloutput, 'status' => $status);
}

}
