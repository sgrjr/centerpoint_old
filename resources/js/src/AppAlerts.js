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

    if(open){
        return(

      <Stack className="noPrint" direction="column" justifyContent="space-evenly" alignItems="flex-end" spacing={2} sx={{ width: '100%' }}>
        <Snackbar open={open}
                    autoHideDuration={6000}
                  onClose={handleAlerts}
                  severity={alert.severity}
                  anchorOrigin={{ vertical:"bottom", horizontal:"right" }}
                >
                    <MuiAlert onClose={handleAlerts} severity={alert.severity}  variant="filled" >
                    {alert.message} {alert.debugMessage? alert.debugMessage:""}
                    </MuiAlert>
                </Snackbar>
      </Stack>)}else{
        return <div/>
      }
        
        

        
    }
        
}    

const mapStateToProps = (state)=>{
return {
    open: state.notification.open,
    item: state.notification.item
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