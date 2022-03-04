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

import styles from "../styles.js"

const drawerWidth = 240;

  const useStyles = (theme => ({
    root: {

    },
    appBar: {
      zIndex: theme.zIndex.drawer + 1,
      transition: theme.transitions.create(['width', 'margin'], {
        easing: theme.transitions.easing.sharp,
        duration: theme.transitions.duration.leavingScreen,
      }),
    },
    appBarShift: {
      marginLeft: drawerWidth,
      width: `calc(100% - ${drawerWidth}px)`,
      transition: theme.transitions.create(['width', 'margin'], {
        easing: theme.transitions.easing.sharp,
        duration: theme.transitions.duration.enteringScreen,
      }),
    },
    menuButtonHidden: {
      display: 'none',
    },
    drawerPaper: {
      position: 'relative',
      whiteSpace: 'nowrap',
      width: drawerWidth,
      transition: theme.transitions.create('width', {
        easing: theme.transitions.easing.sharp,
        duration: theme.transitions.duration.enteringScreen,
      }),
    },
    drawerPaperClose: {

    },
    appBarSpacer: theme.mixins.toolbar,
    content: {
      flexGrow: 1
    },
    paper: {
      padding: theme.spacing(2),
      display: 'flex',
      overflow: 'auto',
      flexDirection: 'column',
    }
  }));

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

    componentWillReceiveProps(newProps){
      //console.log(this.props, newProps, 99)
    }


    toggleDrawer(){
      this.setState({open: !this.state.open})
    }

    render(){

        const { classes, links} = this.props;    
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
              <IconButton onClick={toggleDrawer}>
                <IconPicker icon={open? "chevronLeft":"chevronRight"} />
              </IconButton>

              {dashboardnav()}
          </div>
          }
        }

        return(
          <div className={styles.dashboard +" "+ "drawer-is-open-"+open}>
         
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
        </div>
        )
    }
        
}    

const dashboardQuery = {
  query:`{
    viewer {
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

export default connect(mapStateToProps, mapDispatchToProps)(withStyles(useStyles)(Dashboard))