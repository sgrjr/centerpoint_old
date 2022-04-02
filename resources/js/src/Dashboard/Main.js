import React, { Component } from 'react';
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
import Widget from '../components/Widget'
import actions from '../actions';
import { connect } from 'react-redux'

class DashboardMain extends Component {

   componentDidMount(){
      if(!this.props.viewer || !this.props.viewer.vendor.processing){
        this.props.dashboardMainGet(dashboardMainQuery) 
      }
    }

  render(){

  return (
    <Grid container spacing={3}>

            <Grid item xs={12} md={4} lg={5}>
              <Card>
                <Widget ready={true} title="Change Profile Picture">
                  <ChangePicture {...this.props} />
                </Widget>
              </Card>
            </Grid>

            <Grid item xs={12} md={8} lg={7}>
              <Card>
                <Profile {...this.props}/>
              </Card>
            </Grid>

            <Grid item xs={12} md={8} lg={7}>
              <Card>
                <Users {...this.props}/>
              </Card>
            </Grid>

            <Grid item xs={12} md={6}>
              <Card>
                <ActiveStandingOrders {...this.props} />
              </Card>
            </Grid>

            <Grid item xs={12}  md={6}>
              <Card>
                <CancelledStandingOrders {...this.props} />
              </Card>
            </Grid>
       
            <Grid item xs={12}>
              <Card>
                <ProcessingOrders {...this.props} />
              </Card>
            </Grid>

            <Grid item xs={12}>
              <Card><RecentOrders  {...this.props} /></Card>
            </Grid>
            
            <Grid item xs={12}>
              <Card>
                <BackOrders  {...this.props}/>
              </Card>
            </Grid>

            <Grid item xs={12} md={6}>
              <Card>
                <QuickLinks  {...this.props}/>
              </Card>
            </Grid>

            <Grid item xs={12} md={6}>
              <Card>
                <AccountRep {...this.props} />
              </Card>
            </Grid>
    </Grid>
  );
}
}

const dashboardMainQuery = {
  query:`{
    viewer {

        vendor {
          KEY
          ORGNAME
          cartsCount
          processingCount
          isbns
          
          users (first:100) {
            data{
              EMAIL
              FIRST
              LAST
            }

          }

          processing(first:100){
            data {
              id
              KEY
              DATE
              PO_NUMBER
              TRANSNO
              REMOTEADDR
            }

          }
            back: backOrders (first:10){
             data {
              id
              KEY
              DATE
              PO_NUMBER
              TRANSNO
             }
          }
            recent: broOrders (first:10){
             data {
              id
              KEY
              DATE
              PO_NUMBER
              TRANSNO
              UPS_KEY
              UPS_KEY_2
              UPS_KEY_3
              UPS_KEY_4
              UPS_KEY_5
            }
          }
          
          ancient: ancientOrders (first:10){
            data {
              id
              KEY
              DATE
              PO_NUMBER
              TRANSNO
              UPS_KEY
              UPS_KEY_2
              UPS_KEY_3
              UPS_KEY_4
              UPS_KEY_5
           }
          }

          old: allOrders (first:10){
            data {
              id
              KEY
              DATE
              PO_NUMBER
              TRANSNO
              UPS_KEY
              UPS_KEY_2
              UPS_KEY_3
              UPS_KEY_4
              UPS_KEY_5
            }
          }

          activeSos: activeStandingOrders(first:100) {
            data{
              id
              KEY
              SOSERIES
              discount
              EXP_MONTH
              EXP_YEAR
              SDATE
              EDATE
              CANCELDATE
            }
          }
          inactiveSos: inactiveStandingOrders(first:100) {
            data{
              id
              KEY
              SOSERIES
              discount
              EXP_MONTH
              EXP_YEAR
              SDATE
              EDATE
              CANCELDATE
            }
          }
        }
      }
    
  }  
  `, 
  variables: []
};


const mapStateToProps = (state)=>{
return {
    user: state.viewer,
    photo: state.forms.photo,
    mytitles: state.viewer.mytitles
     }
}

const mapDispatchToProps = dispatch => {
    return {
      dashboardMainGet: (query) => {
        dispatch(actions.viewer.VIEWER_UPDATE.creator(query))
      },
      uploadFile: (file) => {
        dispatch(actions.form.UPLOAD.creator(file))
      },
      updateForm: (e) => {
        dispatch(actions.form.FORM_UPDATE.creator(e))
      }
    }
  }

export default connect(mapStateToProps, mapDispatchToProps)(DashboardMain)