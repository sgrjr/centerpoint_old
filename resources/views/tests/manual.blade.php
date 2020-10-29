<h1>Tests</h1>

<h2>User Actions</h2>

<ul>
	<li>Navigate to URL</li>
	<li>Login</li>
	<li>Logout</li>
	<li>Add to Cart</li>
	<li>Remove from Cart</li>
	<li>Quantity Update</li>
	<li>Address Update</li>
	<li>Submit Cart</li>
	<li>Delete Cart</li>
	<li>PO Update</li>
</ul>




<h2>Tests</h2>

<h3>URL Tester</h3>

<form method="POST">
	@csrf

	<select name="test">
		<option value=0 >NONE</option>
		<option value=1 >Url Tester = / </option>
		<option value=2 >Random User = /random </option>
		<option value=4 >Authorized User = /user </option>
	</select>

	<input type="submit"/>
</form>

CREDENTIALS TESTER
<form method="POST">
	@csrf

	<input type="hidden" name="test" value=3>
	<input type="text" name="email"/>
	<input type="text" name="password"/>
	<input type="submit"/>
</form>

@include('tests.' . $id)