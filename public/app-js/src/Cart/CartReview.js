import React from 'react';
import Image from '../components/Image'

export default function MyCartList(props) {

  return (<React.Fragment>

				<div className="container ">

	 
		<h2>Shopping Cart <span className="badge badge-primary">(open)</span> DATE: 20191021</h2>
	
	<table id="cart" className="table table-hover table-condensed">

    				<thead>
						<tr>
							<th colspan="2">Product</th>
							<th>Invoice Type</th>
							<th>Price</th>
							<th>Quantity</th>
							<th className="text-center">Subtotal</th>
						</tr>
					</thead>
					<tbody>

					
												<tr>
							<td data-th="Product" colspan="2">
								<div className="row">

								<form action="/cart/update" method="post">
								  <input type="hidden" name="_token" id="csrf-token" value="Srg5jrrHIGnAZiMWrQhGvEwPNbQA3aZ3j9zlupoL"/>
								  <input type="hidden" name="index" value="4797"/>
								  <input type="hidden" name="_method" value="POST"/>
								  <input type="hidden" name="action" value="remove_title"/>
								  <input type="hidden" className="form-control text-center" id="qty" name="qty" value="0"/>
								  <button className="btn btn-danger btn-sm" type="submit"><i className="fas fa-trash-alt"></i></button>
								</form> 

									<a href="/isbn/9781628999549">
									<Image src="https://centerpointlargeprint.com/cp_info/cp_pictures/158/9781628999549.JPG" alt="..." className="cover-art" align="Left"/>
									
									<h4>"Wedding Pearls" by Brown, Carolyn</h4>
									</a>

								</div>
							</td>

							<td>CENTE</td>
							<td data-th="Price">$ 28.46 </td>
							<td data-th="Quantity">
								<form action="/cart/update" method="post">
								  <input type="hidden" name="_token" id="csrf-token" value="Srg5jrrHIGnAZiMWrQhGvEwPNbQA3aZ3j9zlupoL"/>
								  <input type="hidden" name="index" value="4797"/>
								  <input type="hidden" name="_method" value="POST"/>
								  <input type="hidden" name="action" value="change_title_quantity"/>
								  <input type="number" className="text-center" style={{width:"55px"}} id="qty" name="qty" placeholder="1" min="1" max="100" value="1"/>
								  <button className="btn btn-primary btn-sm" type="submit" value="save changes"><i className="fas fa-save"></i></button>
								</form> 
								
							</td>
							<td data-th="Subtotal" className="text-center">$ 28.46</td>
						</tr>
						                    
												<tr>
							<td data-th="Product" colspan="2">
								<div className="row">

								<form action="/cart/update" method="post">
								  <input type="hidden" name="_token" id="csrf-token" value="Srg5jrrHIGnAZiMWrQhGvEwPNbQA3aZ3j9zlupoL"/>
								  <input type="hidden" name="index" value="4801"/>
								  <input type="hidden" name="_method" value="POST"/>
								  <input type="hidden" name="action" value="remove_title"/>
								  <input type="hidden" className="form-control text-center" id="qty" name="qty" value="0"/>
								  <button className="btn btn-danger btn-sm" type="submit"><i className="fas fa-trash-alt"></i></button>
								</form> 

									<a href="/isbn/9781683246367">
									<img src="https://centerpointlargeprint.com/cp_info/cp_pictures/158/9781683246367.JPG" alt="..." className="cover-art" align="Left"/>
									<h4>"Wayward" by Crouch, Blake</h4>
									</a>

								</div>
							</td>

							<td>CENTE</td>
							<td data-th="Price">$ 29.21 </td>
							<td data-th="Quantity">
								<form action="/cart/update" method="post">
								  <input type="hidden" name="_token" id="csrf-token" value="Srg5jrrHIGnAZiMWrQhGvEwPNbQA3aZ3j9zlupoL"/>
								  <input type="hidden" name="index" value="4801"/>
								  <input type="hidden" name="_method" value="POST"/>
								  <input type="hidden" name="action" value="change_title_quantity"/>
								  <input type="number" className="text-center" style={{width:"55px"}} id="qty" name="qty" placeholder="1" min="1" max="100" value="1"/>
								  <button className="btn btn-primary btn-sm" type="submit" value="save changes"><i className="fas fa-save"></i></button>
								</form> 
								
							</td>
							<td data-th="Subtotal" className="text-center">$ 29.21</td>
						</tr>
						                    
												<tr>
							<td data-th="Product" colspan="2">
								<div className="row">

								<form action="/cart/update" method="post">
								  <input type="hidden" name="_token" id="csrf-token" value="Srg5jrrHIGnAZiMWrQhGvEwPNbQA3aZ3j9zlupoL"/>
								  <input type="hidden" name="index" value="4802"/>
								  <input type="hidden" name="_method" value="POST"/>
								  <input type="hidden" name="action" value="remove_title"/>
								  <input type="hidden" className="form-control text-center" id="qty" name="qty" value="0"/>
								  <button className="btn btn-danger btn-sm" type="submit"><i className="fas fa-trash-alt"></i></button>
								</form> 

									<a href="/isbn/9781683246404">
									<img src="https://centerpointlargeprint.com/cp_info/cp_pictures/158/9781683246404.JPG" alt="..." className="cover-art" align="Left"/>
									<h4>"Something Beautiful Happened" by Corporon, Yvette Manessis</h4>
									</a>

								</div>
							</td>

							<td>CENTE</td>
							<td data-th="Price">$ 28.46 </td>
							<td data-th="Quantity">
								<form action="/cart/update" method="post">
								  <input type="hidden" name="_token" id="csrf-token" value="Srg5jrrHIGnAZiMWrQhGvEwPNbQA3aZ3j9zlupoL"/>
								  <input type="hidden" name="index" value="4802"/>
								  <input type="hidden" name="_method" value="POST"/>
								  <input type="hidden" name="action" value="change_title_quantity"/>
								  <input type="number" className="text-center" style={{width:"55px"}} id="qty" name="qty" placeholder="1" min="1" max="100" value="1"/>
								  <button className="btn btn-primary btn-sm" type="submit" value="save changes"><i className="fas fa-save"></i></button>
								</form> 
								
							</td>
							<td data-th="Subtotal" className="text-center">$ 28.46</td>
						</tr>
						                    					</tbody>
					<tfoot>
					
													<tr>
								<td colspan="3"></td>
								<td>Sub Total</td>
								<td className="text-center"><strong> $ 86.13</strong></td>
							</tr>
													<tr>
								<td colspan="3"></td>
								<td>Shipping</td>
								<td className="text-center"><strong> $ ?</strong></td>
							</tr>
													<tr>
								<td colspan="3"></td>
								<td>Paid</td>
								<td className="text-center"><strong> $ 0</strong></td>
							</tr>
													<tr>
								<td colspan="3"></td>
								<td>Grand Total</td>
								<td className="text-center"><strong> $ ?</strong></td>
							</tr>
						
						<tr>

							<td>
								<form action="/cart/update" method="post" onsubmit="return confirm('Are you sure you want to DELETE this cart?');">
								  <input type="hidden" name="_token" id="csrf-token" value="Srg5jrrHIGnAZiMWrQhGvEwPNbQA3aZ3j9zlupoL"/>
								  <input type="hidden" name="index" value="704"/>
								  <input type="hidden" name="_method" value="POST"/>
								  <input type="hidden" name="action" value="delete_cart"/>
								  <input type="hidden" className="form-control text-center" id="qty" name="qty" value="0"/>
								  <button className="btn btn-danger btn-sm" type="submit"><i className="fas fa-trash-alt"></i> DELETE CART</button>
								</form> 
							</td>
							<td></td><td></td><td></td>
							<td>

								<a href="/cart/review/04046.5dad9674d" className="btn btn-success btn-sm" type="submit">Review &amp; Submit Order <i className="fa fa-angle-right"></i></a>
								
							</td>

						</tr>

			<tr><td colspan="5">
					PO#: <form action="/cart/update" method="post">
			  <input type="hidden" name="_token" id="csrf-token" value="Srg5jrrHIGnAZiMWrQhGvEwPNbQA3aZ3j9zlupoL"/>
			  <input type="hidden" name="_method" value="POST"/>
			  <input type="hidden" name="index" value="704"/>
			  <input type="hidden" name="action" value="update_po"/>
			   <input type="text" className="text-center" id="po" name="po" value=""/>

				  <button className="btn btn-success btn-sm" type="submit">Update PO <i className="fa fa-angle-right"></i></button>
			</form>

	</td>
</tr>
<tr>
	<td colspan="5">
							DATE: <form action="/cart/update" method="post">
			  <input type="hidden" name="_token" id="csrf-token" value="Srg5jrrHIGnAZiMWrQhGvEwPNbQA3aZ3j9zlupoL"/>
			  <input type="hidden" name="_method" value="POST"/>
			  <input type="hidden" name="index" value="704"/>
			  <input type="hidden" name="action" value="update_attribute"/>
			   <input type="text" className="text-center" id="attribute_value" name="attribute_value" value="20191021"/>

			   <input type="hidden" name="attribute_name" value="DATE"/>

				  <button className="btn btn-success btn-sm" type="submit">Update DATE <i className="fa fa-angle-right"></i></button>
			</form>

	</td>

			</tr>

			<tr><td colspan="5">
		Billing Line #1: <form action="/cart/update" method="post">
			  <input type="hidden" name="_token" id="csrf-token" value="Srg5jrrHIGnAZiMWrQhGvEwPNbQA3aZ3j9zlupoL"/>
			  <input type="hidden" name="_method" value="POST"/>
			  <input type="hidden" name="index" value="704"/>
			  <input type="hidden" name="action" value="update_attribute"/>
			   <input type="text" className="text-center" id="attribute_value" name="attribute_value" value=""/>

			   <input type="hidden" name="attribute_name" value="BILL_1"/>

				  <button className="btn btn-success btn-sm" type="submit">Update <i className="fa fa-angle-right"></i></button>
			</form>

	</td></tr>

				<tr><td colspan="5">
		Billing Line #2: <form action="/cart/update" method="post">
			  <input type="hidden" name="_token" id="csrf-token" value="Srg5jrrHIGnAZiMWrQhGvEwPNbQA3aZ3j9zlupoL"/>
			  <input type="hidden" name="_method" value="POST"/>
			  <input type="hidden" name="index" value="704"/>
			  <input type="hidden" name="action" value="update_attribute"/>
			   <input type="text" className="text-center" id="attribute_value" name="attribute_value" value="c/o"/>

			   <input type="hidden" name="attribute_name" value="BILL_2"/>

				  <button className="btn btn-success btn-sm" type="submit">Update <i className="fa fa-angle-right"></i></button>
			</form>

	</td></tr>

				<tr><td colspan="5">
		Billing Line #3: <form action="/cart/update" method="post">
			  <input type="hidden" name="_token" id="csrf-token" value="Srg5jrrHIGnAZiMWrQhGvEwPNbQA3aZ3j9zlupoL"/>
			  <input type="hidden" name="_method" value="POST"/>
			  <input type="hidden" name="index" value="704"/>
			  <input type="hidden" name="action" value="update_attribute"/>
			   <input type="text" className="text-center" id="attribute_value" name="attribute_value" value=""/>

			   <input type="hidden" name="attribute_name" value="BILL_3"/>

				  <button className="btn btn-success btn-sm" type="submit">Update <i className="fa fa-angle-right"></i></button>
			</form>

	</td></tr>

				<tr><td colspan="5">
		Billing Line #4: <form action="/cart/update" method="post">
			  <input type="hidden" name="_token" id="csrf-token" value="Srg5jrrHIGnAZiMWrQhGvEwPNbQA3aZ3j9zlupoL"/>
			  <input type="hidden" name="_method" value="POST"/>
			  <input type="hidden" name="index" value="704"/>
			  <input type="hidden" name="action" value="update_attribute"/>
			   <input type="text" className="text-center" id="attribute_value" name="attribute_value" value=","/>

			   <input type="hidden" name="attribute_name" value="BILL_4"/>

				  <button className="btn btn-success btn-sm" type="submit">Update <i className="fa fa-angle-right"></i></button>
			</form>

	</td></tr>


					</tfoot>
				</table>


								
			
	</div>
            </React.Fragment>
  );
}