<form id="simple-add-to-cart" action="/cart/add-to" method="post">
  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
  <input type="hidden" name="isbn" value={{$isbn}}>
  <input type="hidden" name="index" value={{$index}}>
  <input type="hidden" name="_method" value="POST">
 
  <span>quantity: </span>
  <input type="number" id="qty" name="qty" placeholder="1" min="1" max="100" value="1"}/>

  <br><br>
  <input type="submit" value="Add to Cart">
</form>