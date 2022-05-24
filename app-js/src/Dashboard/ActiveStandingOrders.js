import React from 'react';
import Card from '../components/Card'

export default function ActiveStandingOrders(props) {

  return (
    <Card title="Active Standing Orders">
      {props.user.vendor && JSON.stringify(props.user.vendor.activeSos)}
    </Card>
  );
}
