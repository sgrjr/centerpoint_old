import React, { Component } from 'react';
import { connect } from 'react-redux'
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import actions from '../actions';
import { withRouter } from "react-router";
import CircularProgress from '@material-ui/core/CircularProgress';
import Divider from '@material-ui/core/Divider';
import IconButton from '@material-ui/core/IconButton';
import Container from '@material-ui/core/Container';
import clsx from 'clsx';
import Drawer from '@material-ui/core/Drawer';
import ChevronLeftIcon from '@material-ui/icons/ChevronLeft';
import DashboardMain from './Main'
import DashboardNav from './DashboardNav'

const drawerWidth = 240;

  const useStyles = (theme => ({
    root: {
      display: 'flex',
    },
    toolbar: {
      paddingRight: 24, // keep right padding when drawer closed
    },
    toolbarIcon: {
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'flex-end',
      padding: '0 8px',
      ...theme.mixins.toolbar,
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
    button: {
      marginRight: 36,
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
      overflowX: 'hidden',
      transition: theme.transitions.create('width', {
        easing: theme.transitions.easing.sharp,
        duration: theme.transitions.duration.leavingScreen,
      }),
      width: theme.spacing(7),
      [theme.breakpoints.up('sm')]: {
        width: theme.spacing(9),
      },
    },
    appBarSpacer: theme.mixins.toolbar,
    content: {
  //    flexGrow: 1,
//      height: '100vh',
//      overflow: 'auto',
    },
    container: {
     // paddingTop: theme.spacing(4),
     // paddingBottom: theme.spacing(4),
    },
    paper: {
      padding: theme.spacing(2),
      display: 'flex',
      overflow: 'auto',
      flexDirection: 'column',
    },
    fixedHeight: {
      //height: 240,
    },
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
        const fixedHeightPaper = clsx(classes.paper, classes.fixedHeight);
        const content = () => {
          if(this.props.user.vendor !== undefined){
            return <DashboardMain fixedHeightPaper={fixedHeightPaper} classes={classes} {...this.props} />
          }else{
            
            return <CircularProgress color={"secondary"}/>
          }
        }

        const dashboardnav = ()=>{
          if(links !== undefined) {
            return <DashboardNav links={links} />
          }else{
            return <CircularProgress color="secondary"/>
          }
            
        }

        return(
          <div className={classes.root}>
          
         <Drawer
            variant="permanent"
            classes={{
              paper: clsx(classes.drawerPaper, !open && classes.drawerPaperClose),
            }}
            open={open}
          >
            <div className={classes.toolbarIcon}>
              <IconButton onClick={toggleDrawer}>
                <ChevronLeftIcon />
              </IconButton>
            </div>
            <Divider />
              {dashboardnav()}
          </Drawer>

         
          <main className={classes.content}>
            <div className={classes.appBarSpacer} />
            <Container maxWidth="lg" className={classes.container}>
              {content()}
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

        vendor {
          KEY
          ORGNAME
          cartsCount
          processingCount
          isbns
          
          users (first:100) {
            data{
              EMAIL
              FIRST
              LAST
            }

          }

          processing(first:100){
            data {
              id
              KEY
              DATE
              PO_NUMBER
              TRANSNO
              REMOTEADDR
            }

          }
            back: backOrders (first:10){
             data {
              id
              KEY
              DATE
              PO_NUMBER
              TRANSNO
             }
          }
            recent: broOrders (first:10){
             data {
              id
              KEY
              DATE
              PO_NUMBER
              TRANSNO
              UPS_KEY
            }
          }
          
          ancient: ancientOrders (first:10){
            data {
              id
              KEY
              DATE
              PO_NUMBER
              TRANSNO
              UPS_KEY
           }
          }

          old: allOrders (first:10){
            data {
              id
              KEY
              DATE
              PO_NUMBER
              TRANSNO
              UPS_KEY
            }
          }

          activeSos: activeStandingOrders(first:100) {
            data{
              id
              KEY
              SOSERIES
              DISC
              EXP_MONTH
              EXP_YEAR
            }
          }
          inactiveSos: inactiveStandingOrders(first:100) {
            data{
              id
              KEY
              SOSERIES
              DISC
              EXP_MONTH
              EXP_YEAR
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
    links: state.viewer.application? state.viewer.application.links.drawer:[],
    mytitles: state.viewer.mytitles
     }
}

const mapDispatchToProps = dispatch => {
    return {
      dashboardGet: (query) => {
        dispatch(actions.viewer.VIEWER_UPDATE.creator(query))
      },
      uploadFile: (file) => {
        dispatch(actions.form.UPLOAD.creator(file))
      },
      updateForm: (e) => {
        dispatch(actions.form.FORM_UPDATE.creator(e))
      }
    }
  }

export default withRouter(connect(mapStateToProps, mapDispatchToProps)(withStyles(useStyles)(Dashboard)))