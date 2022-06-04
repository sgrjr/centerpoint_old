<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Config, Schema;
use App\Ask\AskTrait\AskTrait;
use App\Models\Traits\ModelTrait;
use App\Models\Traits\ManageTableTrait;
use App\Models\Traits\PresentableTrait;
use App\Models\Traits\ODBCDTrait;

class BaseModel extends Model
{
	use AskTrait, ManageTableTrait, ModelTrait, PresentableTrait, ODBCDTrait;
}
