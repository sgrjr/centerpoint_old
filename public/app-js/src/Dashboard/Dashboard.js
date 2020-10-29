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
import CssBaseline from '@material-ui/core/CssBaseline';
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
    menuButton: {
      marginRight: 36,
    },
    menuButtonHidden: {
      display: 'none',
    },
    title: {
      flexGrow: 1,
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
      flexGrow: 1,
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
        this.props.dashboardGet(dashboardQuery) 
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
          <CssBaseline />
          
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

      links {
        drawer {
          url
          text
          icon
        }
      }
      
      user {

        vendor {
          KEY
          ORGNAME
          cartscount
          processingcount
          
          users {
            EMAIL
            FIRST
            LAST
          }

          carts{
            KEY
            DATE
            PO_NUMBER
            TRANSNO
          }
          processing{
            KEY
            DATE
            PO_NUMBER
            TRANSNO
            REMOTEADDR
          }
            back: order (age:"back",perPage:10,){
            KEY
            DATE
            PO_NUMBER
            TRANSNO
          }
            recent: order (age:"bro", perPage:10){
            KEY
            DATE
            PO_NUMBER
            TRANSNO
          }
          
          activeSos: standingorders(filters: {QUANTITY: ">=_1"}) {
            KEY
            SOSERIES
            DISC
            EXP_MONTH
            EXP_YEAR
          }
          inactiveSos: standingorders(filters: {QUANTITY: "<_1"}) {
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
    user: state.viewer.user,
    photo: state.forms.photo,
    links: state.viewer.links.drawer,
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