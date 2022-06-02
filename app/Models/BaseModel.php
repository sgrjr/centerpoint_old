<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Config, Schema;
use App\Ask\AskTrait\AskTrait;
use App\Traits\ModelTrait;
use App\Traits\ManageTableTrait;
use App\Traits\PresentableTrait;
use App\Traits\ODBCDTrait;

class BaseModel extends Model
{
	use AskTrait, ManageTableTrait, ModelTrait, PresentableTrait, ODBCDTrait;
}
