import React, { Component } from 'react';
import actions from '../actions';
import { connect } from 'react-redux'
import Link from '@material-ui/core/Link';
import Container from '@material-ui/core/Container';
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
import LoginIcon from '@mui/icons-material/Login';
import Checkout from '../Checkout/Checkout'
import CheckoutSuccess from '../Checkout/CheckoutSuccess'

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
  	}}><LoginIcon/> <i>IMPERSONATE</i> {user.FIRST} {user.LAST}</button>

    <p><b>Logins with</b>: (email) {user.EMAIL}</p>

      <h2>Carts ({this.props.cartsCount})</h2>

      {user && user.vendor && user.vendor.carts && user.vendor.carts.data.map((cart, k)=>{

        return <Container key={k} maxWidth="md">

          {!cart.ISCOMPLETE &&
            <Checkout {...this.props} addresses={this.props.addresses} data={cart} />
          }
          {cart.ISCOMPLETE &&
            <CheckoutSuccess {...this.props} addresses={this.props.addresses} data={cart}/>
          }

        </Container>
      })}

      <h2>Roles & Permissions</h2>
      <ul>
      {user && user.roles && user.roles.map((role, k)=>{
        return <li key={k}>{role.name}<ul>{role.permissions.map((permission)=>{ return <li>{permission.name}</li>})}</ul></li>
      })}
      </ul>

  </div>
  );
}
}

AdminUser.propTypes = {
    location: PropTypes.object
};

const adminUserQuery = (variables)=>{

if(!variables.cartsLimit) {variables['cartsLimit'] = 100}
  
 return { query:`query ($id: String, $cartsLimit: Int!) {
          user (id: $id) {
              EMAIL
              FIRST
              LAST
              public_id
              roles{
                name
                permissions{
                  name
                }
              }
              vendor{
                addresses {
                  BILL_1
                  BILL_2
                  BILL_3
                  BILL_4
                }
                carts(first:$cartsLimit){
                  data{
                     id
                    INDEX
                    KEY
                    DATE
                    PO_NUMBER
                    TRANSNO
                    REMOTEADDR
                    ISCOMPLETE
                    BILL_1
                    BILL_2
                    BILL_3
                    BILL_4
                    CINOTE
                    items{
                      id
                      INDEX
                      PROD_NO
                      TITLE
                      REQUESTED
                      SALEPRICE
                      coverArt
                      AUTHOR
                      AUTHORKEY
                      url
                      INVNATURE
                    }

                    invoice {
                      id
                      title
                      dates
                      headings
                      totaling{
                        subtotal
                        shipping
                        paid
                        grandtotal
                      }
                      company_logo
                      company_website
                      company_name
                      company_address
                      company_telephone
                      company_email
                      customer_name
                      customer_address
                      customer_email
                      thanks
                      invoice_memo
                      footer_memo
                    }

                  }
                }
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
    user: state.admin.data.user,
    addresses: state.admin.data.vendor? state.admin.data.vendor.addresses:[],
    cartsCount: state.admin.data.user? state.admin.data.user.vendor.carts.data.length:0
    }
}

const mapDispatchToProps = dispatch => {
    return {
      adminGet: (query) => {
        dispatch(actions.admin.ADMIN_GET.creator(query))
      },
      loginUser:(input)=>{
      	dispatch(actions.auth.ADMIN_GET_USER.creator(input))
      },
    setIsCompleted:(cart) => {
      dispatch(actions.cart.CART_CHECKOUT.creator(cart))
    },
    }
  }

const AdminUserWithParams = (props)=>{
  return <AdminUser {...props} params={useParams()} location={useLocation()}/>
}

export default connect(mapStateToProps, mapDispatchToProps)(withStyles(useStyles)(AdminUserWithParams))
