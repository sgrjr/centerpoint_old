import React from 'react';
import Card from '../components/Card'

export default function BackOrders(props) {

  return (
    <Card title="Back Orders">
    {props.user.vendor && JSON.stringify(props.user.vendor.back)}
  </Card>
  );
}
