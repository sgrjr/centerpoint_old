import React, { Component } from 'react';
import actions from '../actions';
import { connect } from 'react-redux'
import Link from '@material-ui/core/Link';
import { withStyles } from '@material-ui/core/styles';
import Table from '@material-ui/core/Table';
import TableBody from '@material-ui/core/TableBody';
import TableCell from '@material-ui/core/TableCell';
import TableHead from '@material-ui/core/TableHead';
import TableRow from '@material-ui/core/TableRow';
import {Navigate } from 'react-router-dom';
import IconPicker from '../components/IconPicker'
import {useParams, useLocation} from 'react-router-dom'
import PropTypes from 'prop-types';

const useStyles = (theme => ({
  seeMore: {
    marginTop: theme.spacing(3),
  },
}));

class AdminUser extends Component {

   componentDidMount(){
        this.loadUser()
    }

    loadUser(){
    	this.props.adminGet(adminUserQuery({id:this.props.params.userid})) 
    }

  render(){
	 let loginUser = this.props.loginUser
  	let heading = null
    let headerStyle = {
      margin:"15px"
    }

    let user = {}

    if(this.props.user){
      user = this.props.user
    }
    

  
  return (
  <div>
<button onClick={()=>{
      	loginUser({id: user.public_id})
      	return <Navigate to={"/dashboard"} />
  	}}>TEST</button>
      <p>{user.FIRST} {user.LAST}</p>
      <p align="right">{user.EMAIL}</p>

  </div>
  );
}
}

AdminUser.propTypes = {
    location: PropTypes.object
};

const adminUserQuery = (variables)=>{
 return { query:`query ($id: String) {
          user (id: $id) {
              EMAIL
              FIRST
              LAST
              public_id
              permisions
          }    
  }  
  `, 
  variables: variables
}

};


const mapStateToProps = (state)=>{
return {
    admin: state.admin,
    user: state.admin.data.user
    }
}

const mapDispatchToProps = dispatch => {
    return {
      adminGet: (query) => {
        dispatch(actions.admin.ADMIN_GET.creator(query))
      },
      loginUser:(input)=>{
      	dispatch(actions.auth.ADMIN_GET_USER.creator(input))
      }
    }
  }

const AdminUserWithParams = (props)=>{
  return <AdminUser {...props} params={useParams()} location={useLocation()}/>
}

export default connect(mapStateToProps, mapDispatchToProps)(withStyles(useStyles)(AdminUserWithParams))
