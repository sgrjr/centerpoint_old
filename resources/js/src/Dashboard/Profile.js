import React from 'react';
import Card from '../components/Card'
import Typography from '@material-ui/core/Typography';

export default function Profile(props) {

  return (
    <Card title="Profile" className="profile">
       <h5>{props.user.name}</h5>
       <h5>{props.user.EMAIL}</h5>
       <h5>{props.user.vendor? props.user.vendor.ORGNAME:""}</h5>
    </Card>
  );
}
