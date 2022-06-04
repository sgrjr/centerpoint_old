import React, { Component } from 'react';
import { connect } from 'react-redux'
import Button from '@mui/material/Button';
import Stack from '@mui/material/Stack';
import Snackbar from '@mui/material/Snackbar';
import SnackbarContent from '@mui/material/SnackbarContent';
import actions from './actions';
import IconButton from '@mui/material/IconButton';
import CloseIcon from '@mui/icons-material/Close';
import MuiAlert from '@mui/material/Alert';
import AlertTitle from '@mui/material/AlertTitle';

class AppAlerts extends Component{

    render(){

        const open = this.props.open
        const handleAlerts = this.props.dissmissAlerts
        const alert = this.props.item
        const alertsCount = this.props.alertsCount
        const time = 3000
    if(open){
        return(

      <Stack className="noPrint" direction="column" justifyContent="space-evenly" alignItems="flex-end" spacing={2} sx={{ width: '100%' }}>
        <Snackbar open={open}
                    autoHideDuration={time}
                  onClose={handleAlerts}
                  severity={alert.severity}
                  anchorOrigin={{ vertical:"bottom", horizontal:"right" }}
                >
                    <MuiAlert onClose={handleAlerts} severity={alert.extensions && alert.extensions.severity? alert.extensions.severity:alert.severity}  variant="filled" >
                    [{alertsCount}] {alert.message} 
                    {alert.debugMessage? <div dangerouslySetInnerHTML={{__html:alert.debugMessage}}/>:""} 
                    {alert.extensions && alert.extensions.reason? alert.extensions.reason:""}
                    </MuiAlert>
                </Snackbar>
      </Stack>)}else{
        return null;
      }
        
    }
        
}    

const mapStateToProps = (state)=>{
return {
    open: state.notification.open,
    item: state.notification.item,
    alertsCount: state.notification.items.length
     }
}

const mapDispatchToProps = dispatch => {
    return {
      dissmissAlerts: () => {
        dispatch(actions.notification.NOTIFICATION_DISMISS.creator() )
      }
    }
  }

export default connect(mapStateToProps, mapDispatchToProps)(AppAlerts)