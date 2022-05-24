import React, { Component } from 'react';
import { connect } from 'react-redux'
import PropTypes from 'prop-types';
import actions from '../actions';
import { withRouter } from "react-router";
import Grid from '@material-ui/core/Grid';
import Main from './Main'
import Nav from './Nav'
import navbarQuery from '../components/navbarQuery'
import cartQuery from '../Cart/cartQuery'

class Index extends Component{

  constructor(props){
    super(props)

    this.state = {
      open: true
    }
  }

   componentDidMount(){
        this.props.adminGet(this.props.adminQuery) 
    }

    componentWillReceiveProps(newProps){
      console.log(this.props, newProps, 99)
    }

    render(){

        return(
          <Grid container>
            <Grid item xs={12} md={3}>
              <Nav {...this.props}/>
            </Grid>
          
            <Grid item xs={12} md={9}>
              <Main {...this.props} navbarQuery={navbarQuery()} cartQuery={cartQuery({perPage:20})}/>
            </Grid>
          </Grid>
        )
    }
        
}    

Index.propTypes = {
    loadClientPending: PropTypes.func,
  };

const mapStateToProps = (state)=>{
return {
    admin: state.admin.data,
    pending: state.admin.pending,
    errors: state.admin.errors,
    links: state.admin.links,
    titles: state.titles,
    carts: state.cart,
    viewer: state.viewer,
    notification: state.notification,
    adminQuery: state.admin.adminQuery,
    titlesQuery: state.admin.titlesQuery,
    titleQuery: state.admin.titleQuery,
    progress: state.admin.progress
     }
}

const mapDispatchToProps = dispatch => {
    return {
      adminGet: (query) => {
        dispatch(actions.admin.ADMIN_GET.creator(query))
      },
      updateAdminQuery: (e) => {
        dispatch(actions.admin.UPDATE_ADMIN_QUERY.creator(e))
      },
      titlesGet: (query) => {
        dispatch(actions.titles.TITLES_GET.creator(query))
      },
      titleGet: (query) => {
        dispatch(actions.titles.TITLE_GET.creator(query))
      },
      cartGet: (query) => {
        dispatch(actions.cart.CART_GET.creator(query))
      },
      fetchViewer: (query) => {
        dispatch(actions.viewer.VIEWER_GET.creator(query))
      },
    }
  }

export default withRouter(connect(mapStateToProps, mapDispatchToProps)(Index))