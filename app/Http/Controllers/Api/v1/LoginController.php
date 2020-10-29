<?php namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\v1\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Core\AuthenticatesUsersTrait AS AuthenticatesUsers;

class LoginController extends BaseController
{
	use AuthenticatesUsers;
}
