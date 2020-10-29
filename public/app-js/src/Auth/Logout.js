import React from 'react';
import {Redirect} from 'react-router-dom';
import { connect } from 'react-redux'
import PropTypes from 'prop-types';
import actions from '../actions';

class Logout extends React.Component {

  render(){
    if(this.props.user.authenticated){
      this.props.logout()
    }

    return <Redirect to={"/"} />
  }
}

Logout.propTypes = {
  user: PropTypes.object
};

const mapStateToProps = (state)=>{
  return {
    user: state.viewer.user
    }
  }
  
  const mapDispatchToProps = dispatch => {
    return {
      logout: () => {
        dispatch(actions.auth.AUTH_LOGOUT.creator())
      }
    }
  }  

  export default connect(mapStateToProps, mapDispatchToProps)(Logout)