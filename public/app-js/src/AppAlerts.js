import React, { Component } from 'react';
import { connect } from 'react-redux'
import Snackbar from '@material-ui/core/Snackbar';
import Alert from '@material-ui/lab/Alert';
import actions from './actions';

class AppAlerts extends Component{
       
    render(){

        const open = this.props.open
        const handleAlerts = this.props.dissmissAlerts

        return(
            <div className="noPrint">
        {this.props.items.map(function(alert, i){
          return <Snackbar key={i} open={open} autoHideDuration={9000} onClose={handleAlerts}>
        <Alert key={alert.message} onClose={handleAlerts} severity={alert.severity}>{alert.message}. {alert.debugMessage? alert.debugMessage:""}</Alert></Snackbar>
        })}
            </div>
        )
    }
        
}    

const mapStateToProps = (state)=>{
return {
    open: state.notification.open,
    items: state.notification.items
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