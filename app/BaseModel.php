<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Config, Schema;
use App\Ask\AskTrait\AskTrait;
use App\Core\ModelTrait;
use App\Core\ManageTableTrait;
use App\Core\PresentableTrait;

class BaseModel extends Model
{

	use AskTrait, ManageTableTrait, ModelTrait, PresentableTrait;
}
