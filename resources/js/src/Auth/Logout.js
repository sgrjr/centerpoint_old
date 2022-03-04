import React from 'react';
import {Navigate } from 'react-router-dom';
import { connect } from 'react-redux'
import PropTypes from 'prop-types';
import actions from '../actions';

class Logout extends React.Component {

  componentDidMount(){
    if(this.props.viewer !== false){
      this.props.logout()
    }
  }
  render(){
    return <Navigate  to={"/"} />
  }
}

Logout.propTypes = {
  user: PropTypes.object
};

const mapStateToProps = (state)=>{
  return {
      viewer: state.viewer,
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