import React from 'react';
import Card from '../components/Card'
import Typography from '@material-ui/core/Typography';

export default function Profile(props) {

  return (
    <Card title="Profile">
       <Typography variant="h3" color="textSecondary" align="center">{props.user.name}</Typography>
       <Typography variant="h4" color="textSecondary" align="center">{props.user.email}</Typography>
       <Typography variant="body" color="textSecondary" align="left">{props.user.vendor? props.user.vendor.ORGNAME:""}</Typography>
    </Card>
  );
}
