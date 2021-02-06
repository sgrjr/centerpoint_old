import React from 'react';
import Card from '../components/Card'

export default function Users(props) {

  let users = null

  if(props.user.vendor){
    users = JSON.stringify(props.user.vendor.users)
  }

  return (
    <Card title="Manage Users">
    {users}
    
  </Card>
  );
}
