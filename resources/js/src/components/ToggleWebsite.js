import React from 'react';

import { Link } from "react-router-dom";
import { connect } from 'react-redux'
import PropTypes from 'prop-types';
import actions from '../actions';
import ToggleOffIcon from '@mui/icons-material/ToggleOff';
import ToggleOnIcon from '@mui/icons-material/ToggleOn';

class ToggleWebsite extends React.Component {
  
  constructor(props){
    super(props)
  }

  render(){

    return (<button className="toggle-website"
         onClick={()=>{
            if(this.props.oldWebsite){
                this.props.toggleWebsite(this.props.oldWebsite)
            }else{
                this.promptForUnsecureSite()
            }
        }}
        >
        {this.props.oldWebsite? <ToggleOnIcon style={{height:"40px", width:"15px"}}/>:<ToggleOffIcon style={{height:"40px"}}/>} 
        {this.props.oldWebsite? "This is an unsecured version of our website. Click here for our Secure Website. ":"Use Old Website"}
    </button>)
  }

  promptForUnsecureSite(){
    this.checkConfirmation(prompt("Are you sure you want to use an unsecure website? (Type \'yes\' to continue or press cancel.)"));
  }

  checkConfirmation(resp){
    if(resp.toLowerCase() === "yes"){
        this.props.toggleWebsite(this.props.oldWebsite)
    }
  }


}

const mapStateToProps = (state)=>{
  return {
    oldWebsite: state.application.oldWebsite
  }
}
  
  const mapDispatchToProps = dispatch => {
    return {
      toggleWebsite:(current) => {
        dispatch(actions.application.TOGGLE_OLD_WEBSITE.creator(current))
      }
    }
  }  

  export default connect(mapStateToProps, mapDispatchToProps)(ToggleWebsite)

