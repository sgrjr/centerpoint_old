import React from 'react';
import Card from '../components/Card'

export default function CancelledStandingOrders(props) {

  return (
    <Card title="Cancelled Standing Orders">
    { props.user.vendor && JSON.stringify(props.user.vendor.inActiveSos)}
  </Card>
  );
}
