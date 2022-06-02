<h2>Database Tables</h2>

<table >
	<tr>
		<th>ACTIONS</th>
		<th>NAME</th>
		<th>EXISTS</th>
		<th>ROWS</th>
		<th>SOURCE</th>
		<th>UPDATED</th>
		<th>CREATED</th>
		<th>MEMO</th>
	</tr>
	
	@foreach($tables AS $t)
	<tr class={{($t->exists)? "greenrow":"redrow"}}>
		<td>
			
			@if($t->exists)
				
				@if($t->mysqlCount > 0) 
				<form action="/admin/db" method="post">
				  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
				  <input type="hidden" name="_method" value="POST">
				  <input type="hidden" id="command" name="command" value="TRUNCATE_TABLE"/>
				  <input type="hidden" id="options" name="options" value={{"{\"name\":\"" . $t->tableSafeName . "\"}"}} />
				  <input type="submit" value="TRUNCATE">
				</form> 
				@endif
				
					<form action="/admin/db" method="post">
					  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
					  <input type="hidden" name="_method" value="POST">
					  <input type="hidden" id="command" name="command" value="SEED_TABLE"/>
					  <input type="hidden" id="options" name="options" value={{"{\"name\":\"" . $t->tableSafeName . "\"}"}} />
					  <input type="submit" value="SEED">
					</form> 

			<form action="/admin/db" method="post">
			  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
			  <input type="hidden" name="_method" value="POST">
			  <input type="hidden" id="command" name="command" value="DROP_TABLE"/>
			  <input type="hidden" id="options" name="options" value={{"{\"name\":\"" . $t->tableSafeName . "\"}"}} />
			  <input type="submit" value="DROP">
			</form> 

			<form action="/admin/db" method="post">
			  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
			  <input type="hidden" name="_method" value="POST">
			  <input type="hidden" id="command" name="command" value="REBUILD_TABLE"/>
			  <input type="hidden" id="options" name="options" value={{"{\"name\":\"" . $t->tableSafeName . "\"}"}} />
			  <input type="submit" value="REBUILD">
			</form> 

			@else

			<form action="/admin/db" method="post">
			  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
			  <input type="hidden" name="_method" value="POST">
			  <input type="hidden" id="command" name="command" value="CREATE_TABLE"/>
			  <input type="hidden" id="options" name="options" value={{"{\"name\":\"" . $t->tableSafeName . "\"}"}} />
			  <input type="submit" value="CREATE">
			</form> 
			@endif
			
		</td><!-- ACTIONS-->

		<td><a href={{"/admin/" . $t->tableSafeName}} >{{$t->manager()->name}}</a></td> <!-- NAME --></td>

		<td>{{$t->exists? "true":"false"}}</td>
		
		<td>{{$t->mysqlCount}} / ?</td>
		
		<td>{{$t->source}}</td>
		
		@if($t->manager()->updated_at !== null)
		<td>{{$t->manager()->updated_at->diffForHumans() }}</td>
		@endif
		@if($t->manager()->created_at !== null)
		<td>{{$t->manager()->created_at->diffForHumans()}}</td>
		@endif
		<td>{{$t->getMemo()}}</td><!-- MEMO-->

	</tr>
	@endforeach
	
</table>