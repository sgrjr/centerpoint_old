import React from 'react';
import Card from '../components/Card'
import {Link} from 'react-router-dom'

export default function ProcessingOrders(props) {

  return (
    <Card title="Processing Orders">
    {props.user.vendor && props.user.vendor.processing && props.user.vendor.processing.map(function(c){
      return <p><Link to={"/cart/"+c.REMOTEADDR}>PO: {c.PO_NUMBER} DATE: {c.DATE} (INVOICE#: {c.REMOTEADDR})</Link></p>
    })}
  </Card>
  );
}
