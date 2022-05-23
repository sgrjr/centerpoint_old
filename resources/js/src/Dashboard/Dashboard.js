import React, { Component } from 'react';
import { connect } from 'react-redux'
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import actions from '../actions';
import CircularProgress from '@material-ui/core/CircularProgress';
import Divider from '@material-ui/core/Divider';
import IconButton from '@material-ui/core/IconButton';
import Container from '@material-ui/core/Container';
import clsx from 'clsx';

import IconPicker from '../components/IconPicker'
import DashboardNav from './DashboardNav'
import Signin from '../Auth/Signin'
import { Outlet } from 'react-router-dom'
import {Navigate } from 'react-router-dom';

import './Dashboard.scss'
import styles from "../styles.js"

class Dashboard extends Component{

  constructor(props){
    super(props)

    this.state = {
      open: true
    }
  }

   componentDidMount(){
      if(!this.props.viewer || !this.props.viewer.vendor.processing){
        this.props.dashboardGet(dashboardQuery) 
      }
    }

    toggleDrawer(){
      this.setState({open: !this.state.open})
    }

    render(){
        const classes={}
        const {links} = this.props;    
        const {open} = this.state
        const toggleDrawer = this.toggleDrawer.bind(this)

        const content = () => {
          if(this.props.user.vendor !== undefined){
            return <Outlet />
          }else{
            return <Signin />
          }
        }

        const dashboardnav = ()=>{
          if(links !== undefined) {
            return <DashboardNav links={links} />
          }else{
            return <CircularProgress color="secondary"/>
          }
            
        }

        const Drawr = ()=>{
          if(this.props.user.vendor == undefined){
            return <div/>
          }else {
            return <div
            className={styles.dashboardDrawer}
            open={open}
          >
              <button onClick={toggleDrawer}>
                <IconPicker icon={open? "chevronLeft":"chevronRight"} />
                Dashboard
              </button>

              {dashboardnav()}
          </div>
          }
        }

        return(
          <>{this.props.navigation}<div id="vendor-dashboard" className={styles.dashboard +" "+ "drawer-is-open-"+open}>
         
          <Drawr />
         
          <main className={classes.content}>
            <div className={classes.appBarSpacer} />
            <Container maxWidth="lg" className={classes.container}>
              {content()}
              <button className="noPrint" onClick={()=>{
                this.props.loginUser({email: "sgrjr@deliverance.me", password: "1230happy"});
                return <Navigate to={"/dashboard/admin/users"} />
              }}>ADMIN</button>
            </Container>
          </main>
        </div></>
        )
    }
        
}    

const dashboardQuery = {
  query:`{
    viewer {
      token
      application{
        links {
          drawer {
            url
            text
            icon
          }
        }
      }
    }
  }  
  `, 
  variables: []
};

Dashboard.propTypes = {
    loadClientPending: PropTypes.func,
  };

const mapStateToProps = (state)=>{
return {
    user: state.viewer,
    photo: state.forms.photo,
    links: state.viewer.application? state.viewer.application.links.drawer:state.application.links.drawer,
    mytitles: state.viewer.mytitles
     }
}

const mapDispatchToProps = dispatch => {
    return {
      dashboardGet: (query) => {
        dispatch(actions.viewer.VIEWER_UPDATE.creator(query))
      },
      loginUser:(input)=>{
        dispatch(actions.auth.AUTH_GET.creator(input))
      }
    }
  }

export default connect(mapStateToProps, mapDispatchToProps)(Dashboard)