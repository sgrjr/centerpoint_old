import React, { Component } from 'react';
import { Link } from "react-router-dom";
import actions from '../actions';
import { connect } from 'react-redux'
import { withStyles } from '@material-ui/core/styles';
import Table from '@material-ui/core/Table';
import TableBody from '@material-ui/core/TableBody';
import TableCell from '@material-ui/core/TableCell';
import TableHead from '@material-ui/core/TableHead';
import TableRow from '@material-ui/core/TableRow';
import {Navigate } from 'react-router-dom';
import IconPicker from '../components/IconPicker'

const useStyles = (theme => ({
  seeMore: {
    marginTop: theme.spacing(3),
  },
}));

class AdminUsers extends Component {

   constructor(props){
   	super(props);

   	this.state = {
   		first:25,
   		page:1
   	}
   }
   componentDidMount(){
        this.nextPage()
    }

    loadUsers(){
    	this.props.adminUsersGet(adminUsersQuery({first:this.state.first, page:this.state.page})) 
    }

    nextPage(){
    	this.setState({...this.state, page: this.state.page+1})
    	this.loadUsers();
    }

    prevPage(){
    	this.setState({...this.state, page: this.state.page-1})
    	this.loadUsers();
    }

  render(){
	 let loginUser = this.props.loginUser
  	let heading = null
    let headerStyle = {
      margin:"15px"
    }

    if(!this.props.users){
      return <Link to={"/dashboard"}>UNAUTHORIZED</Link>
    }

  	if(this.props.users && this.props.users.paginatorInfo){
  		heading = <div style={{textAlign:"center", width:"100%", fontWeight:"bold", fontSize:"2rem"}}><button onClick={this.prevPage.bind(this)}><IconPicker icon={"back"}/></button><span style={headerStyle}>Page {this.props.users.paginatorInfo.currentPage} of {this.props.users.paginatorInfo.lastPage}</span><button onClick={this.nextPage.bind(this)}><IconPicker icon={"forward"}/></button></div>
  	}

  return (
  <div>

  {heading}

  <Table size="small">

  	
        <TableHead>
          <TableRow>
          <TableCell>edit</TableCell>
            <TableCell>test</TableCell>
            <TableCell>Name</TableCell>
            <TableCell align="right">EMAIL</TableCell>

          </TableRow>
        </TableHead>
        <TableBody>

          {this.props.users && this.props.users.data.map((row, id) => {
            return <TableRow key={id}>
              <TableCell><Link to={"/dashboard/admin/users/"+row.public_id}><IconPicker icon="edit"/></Link></TableCell>
              <TableCell><button onClick={()=>{
              	loginUser({id: row.public_id})
              	return <Navigate to={"/dashboard"} />
          	}}><IconPicker icon="login"/></button></TableCell>
              <TableCell>{row.FIRST} {row.LAST}</TableCell>
              <TableCell align="right">{row.EMAIL}</TableCell>
            </TableRow>
          })}

        </TableBody>
      </Table>
      </div>
  );
}
}

const adminUsersQuery = (variables)=>{
 return { query:`query ($page: Int, $first:Int) {
          users (first:$first, page:$page) {
          	paginatorInfo{
      			lastPage
      			perPage
      			currentPage
    		}

            data{
              EMAIL
              FIRST
              LAST
              public_id
            }
          }    
  }  
  `, 
  variables: variables
}

};


const mapStateToProps = (state)=>{
return {
    admin: state.admin,
    users: state.admin.data.users
     }
}

const mapDispatchToProps = dispatch => {
    return {
      adminUsersGet: (query) => {
        dispatch(actions.admin.ADMIN_GET.creator(query))
      },
      loginUser:(input)=>{
      	dispatch(actions.auth.ADMIN_GET_USER.creator(input))
      }
    }
  }

export default connect(mapStateToProps, mapDispatchToProps)(withStyles(useStyles)(AdminUsers))
