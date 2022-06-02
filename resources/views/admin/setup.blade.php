<html>
<head>
	
	<style>
		
	body {
		padding:50px;
	}

	img {
		width:400px;
		margin:auto auto;
	}

	form {
	background: #5898b71a;
	padding:15px;
	}

	</style>

</head>
<body>
	@if(Session::has('message'))
	<p class="alert alert-info">{!! Session::get('message') !!}</p>
	@endif
	
	@if(Session::has('error'))
	<p class="alert alert-warning">{!! Session::get('error') !!}</p>
	@endif

<h1>Welcome to Your New Application!</h1>

<p>You are seeing this page because we need to complete a few tasks before your application is setup and ready to go!</p>

<ol>
	<li>Execute "GIT_PULL" command To make sure you have the most recent updates to your application.</li>
	<li>Execute "COMPOSER_UPDATE" command so your application can pull in all of its dependancies. Once executed, this may took a few minutes to complete.</li>
	<li>Click "MIGRATE TABLES" to create the basic database tables necessary for the application.</li>
	<li>Click "SEED" to fill the databases created in the previous steps with the required initial data.</li>
	<li>Click "OPTIMZE" to fill the databases created in the previous steps with the required initial data.</li>
</ol>

<ol>
<li>Clone your project</li>
<li>Go to the folder application using cd command on your cmd or terminal</li>
<li>Run composer install on your cmd or terminal</li>
<li>Copy .env.example file to .env on the root folder. You can type copy .env.example .env if using command prompt Windows or cp .env.example .env if using terminal, Ubuntu</li>
<li>Open your .env file and change the database name (DB_DATABASE) to whatever you have, username (DB_USERNAME) and password (DB_PASSWORD) field correspond to your configuration.</li>
<li>Run php artisan key:generate</li>
<li>Run php artisan migrate</li>
<li>Run php artisan serve</li>
</ol>

<hr />
<ul>
	@foreach($tests AS $test)
<li><input type="checkbox" id="scales" name="scales" 

	@if ($test->passed)
	checked
	@endif 

	 > {{$test->name}}</li>
	@endforeach
</ul>

<hr />
 	<form action="/setup/terminal" method="post">
	  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
	  <input type="hidden" name="_method" value="POST">
	  <span>command: </span>
	  <input type="text" id="command" name="command" value="GIT_PULL"/>
	  
	  <p>options: </p>
	  <input type="text" id="options" name="options" style="width:100%; display:block"/>
	  <br><br>
	  <input type="submit" value="execute command">
	</form

<ul>
<li><a href={{url("/setup/fresh")}}>Fresh Install</a></li>
<li><a href={{url("/setup/migrate")}}>Migrate Tables</a></li>
<li><a href={{url("/setup/seed")}}>seed</a></li>
<li><a href={{url("/setup/optimize")}}>optimize</a></li>


<blockquote>IMPORTANT NOTE: Before your application can issue personal access tokens, you will need to create a personal access client. You may do this using the passport:client command with the --personal option. If you have already run the passport:install command, you do not need to run this command:

php artisan passport:client --personal</blockquote>
<hr/>
Additional Links:
<li><a href={{url("/setup/rollback")}}>rollback</a></li>
<li><a href={{url("/setup/reset")}}>reset</a></li>

</ul>

<hr />
<ul>
	@foreach($tables AS $table)
<li>{{$table->name}} ({{$table->rows}})</li>
	@endforeach
</ul>

<h2>ERROR</h2>


 	<form id="errorform" action="/setup/terminal" method="post">
	  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
	  <input type="hidden" name="_method" value="POST">
	  <span>command: </span>
	  <input type="hidden" id="command" name="command" value="CLEAR_SERVER_ERRORS"/>
	  
	    <span>error: </span>
		<textarea name="error" form="errorform" rows="25" style="width:100%;">{{$error}}</textarea>
	  <input type="submit" value="CLEAR_SERVER_ERRORS">
	</form>

@if($updateExists)
	{{$update}}
@endif

<img src="data:image/png;base64,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" />

</body>
</html>