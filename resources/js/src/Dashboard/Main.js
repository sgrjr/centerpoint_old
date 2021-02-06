import React from 'react';
import Grid from '@material-ui/core/Grid';
import Card from '@material-ui/core/Card';
import AccountRep from './AccountRep'
import BackOrders from './BackOrders';
import ActiveStandingOrders from './ActiveStandingOrders'
import CancelledStandingOrders from './CancelledStandingOrders'
import ChangePicture from './ChangePicture';
import ProcessingOrders from './ProcessingOrders'
import Profile from './Profile';
import QuickLinks from './QuickLinks'
import RecentOrders from './RecentOrders';
import Users from './Users';
import CircularProgress from '@material-ui/core/CircularProgress';
import Widget from '../components/Widget'

export default function Dashboard(props) {
  
  return (
    <Grid container spacing={3}>

            <Grid item xs={12} md={4} lg={5}>
              <Card >
                <Widget ready={true} title="Change Profile Picture">
                  <ChangePicture {...props} />
                </Widget>
              </Card>
            </Grid>

            <Grid item xs={12} md={8} lg={7}>
              <Card>
                <Profile {...props}/>
              </Card>
            </Grid>

            <Grid item xs={12} md={8} lg={7}>
              <Card>
                <Users {...props}/>
              </Card>
            </Grid>

            <Grid item xs={12} md={6}>
              <Card>
                <ActiveStandingOrders {...props} />
              </Card>
            </Grid>

            <Grid item xs={12}  md={6}>
              <Card>
                <CancelledStandingOrders {...props} />
              </Card>
            </Grid>
       
            <Grid item xs={12}>
              <Card>
                <ProcessingOrders {...props} />
              </Card>
            </Grid>

            <Grid item xs={12}>
              <Card>
                {()=>{
    
                  if(props.user.vendor.recent !== undefined){
                    return <RecentOrders  {...props} />
                  }else{
                    return <CircularProgress color={"secondary"}/>
                  }
                }}
                
              </Card>
            </Grid>

            <Grid item xs={12}>
              <Card>
                <BackOrders  {...props}/>
              </Card>
            </Grid>

            <Grid item xs={12} md={6}>
              <Card>
                <QuickLinks  {...props}/>
              </Card>
            </Grid>

            <Grid item xs={12} md={6}>
              <Card>
                <AccountRep {...props} />
              </Card>
            </Grid>
    </Grid>
  );
}
