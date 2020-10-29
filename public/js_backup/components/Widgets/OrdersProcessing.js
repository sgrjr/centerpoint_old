import React, { Component } from 'react';

export default class OrdersProcessing extends Component {

    render() {

    	if(this.props.data.processing_carts !== undefined){


      return (<div className={this.props.cName}>

		              <ul>

		              {this.props.data.processing_carts.records.map(function(order){
		              	return (<li>
		              			<b>Date:</b>  {order.DATE}
				                <b>Source:</b>   {order.OSOURCE}
				                <b>PO #:</b>    {order.PO_NUMBER}
				                <a href={"/dashboard/orders/bro/"+order.TRANSNO}>View</a>
		              		</li>);
		              })}
		              </ul>


                         </div>
      );
  }else{
  	return ""
  }
            }

 }