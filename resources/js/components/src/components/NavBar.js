import React from 'react';
import Grid from '@material-ui/core/Grid';
import AppBar from '@material-ui/core/AppBar';
import Toolbar from '@material-ui/core/Toolbar';
import IconButton from '@material-ui/core/IconButton';
import Typography from '@material-ui/core/Typography';
import Button from '@material-ui/core/Button';
import MenuItem from '@material-ui/core/MenuItem';
import Menu from '@material-ui/core/Menu';
import MoreIcon from '@material-ui/icons/MoreVert';
import Drawer from '@material-ui/core/Drawer';
import { Link } from "react-router-dom";
import { connect } from 'react-redux'
import PropTypes from 'prop-types';
//import BrowseProducts from './BrowseProducts'
import SearchForm from './SearchForm'
import actions from '../actions';
import CustomMenuLink from './CustomMenuLink'
import { withRouter } from "react-router-dom";
import Cart from '../Cart/Cart'
import ShoppingCartIcon from '@material-ui/icons/ShoppingCartOutlined';
import ClearIcon from '@material-ui/icons/Clear'
import {withTheme} from '@material-ui/core/styles'

//fix this to dynamic some time
import useStyles from './NavbarStyle.js'

const MainNavbar = function (props) {
  const classes = useStyles(props.theme);
  const [anchorEl, setAnchorEl] = React.useState(null);
  const [mobileMoreAnchorEl, setMobileMoreAnchorEl] = React.useState(null);

  const isMenuOpen = Boolean(anchorEl);
  const isMobileMenuOpen = Boolean(mobileMoreAnchorEl);

  const handleProfileMenuOpen = event => {
    setAnchorEl(event.currentTarget);
  };

  const handleMobileMenuClose = () => {
    setMobileMoreAnchorEl(null);
  };

  const handleMenuClose = () => {
    setAnchorEl(null);
    handleMobileMenuClose();
  };

  const handleMobileMenuOpen = event => {
    setMobileMoreAnchorEl(event.currentTarget);
  };

  const menuId = 'primary-search-account-menu';

  let links = props.links

  if(props.viewer !== undefined && props.viewer.application !== undefined){
    console.log('viewer is not mmmm', props.viewer.application.links)
    links = props.viewer.application.links
  }

  const renderMenu = (
    <Menu
      anchorEl={anchorEl}
      anchorOrigin={{ vertical: 'top', horizontal: 'right' }}
      id={menuId}
      keepMounted
      transformOrigin={{ vertical: 'top', horizontal: 'right' }}
      open={isMenuOpen}
      onClose={handleMenuClose}
      className={classes.root}
    >
      {links.main.map(function(it,index){
        return <MenuItem key={index} onClick={handleMenuClose} className="block"><Link to={it.url}>{it.text}</Link></MenuItem>
      })}


    </Menu>
  );

  const mobileMenuId = 'primary-search-account-menu-mobile';

function menuToggle (event){
  if (event.type === 'keydown' && (event.key === 'Tab' || event.key === 'Shift')) {
    return;
  }
}

  const renderMobileMenu = (
    <Menu
      anchorEl={mobileMoreAnchorEl}
      anchorOrigin={{ vertical: 'top', horizontal: 'right' }}
      id={mobileMenuId}
      transformOrigin={{ vertical: 'top', horizontal: 'right' }}
      open={isMobileMenuOpen}
      onClose={handleMobileMenuClose}
    >
      {links.main.map(function(it,index){
        return <CustomMenuLink key={index} classes={classes} data={{
          processingCount: props.processingCount,
          cartsCount: props.cartsCount
        }} 
        link={it} 
        handleProfileMenuOpen={handleProfileMenuOpen} 
        toggleDrawer={menuToggle}
        />
      })}
    </Menu>
  );

  let shoppingCart = null
  let cart = null
              
    if(props.viewer){
      shoppingCart = (<IconButton
      className={classes.menuButton}
      aria-label="open drawer"
      onClick={props.toggleCart}
    ><ShoppingCartIcon /></IconButton>)


      cart = (<Drawer open={props.cart} onClose={props.toggleCart}>
        <Button onClick={props.toggleCart} startIcon={<ClearIcon />}>
              Close
            </Button>
        <Cart />
      </Drawer>)

    }

  return (
      <div>
      
      {cart}

    <div className={classes.grow}>
      <AppBar position="static" color={"default"}>
        <Toolbar>
          
            {shoppingCart}

          <Typography className={classes.title} noWrap>
            <img src={"/img/logo.png"} style={{margin:"auto", display:"block", height:"100%"}} alt="logo"/>
          </Typography>

          <div className={classes.grow} />
          <div className={classes.sectionDesktop}>
          
          {links.main.map(function(it,index){
            return <CustomMenuLink key={index} classes={classes} data={{
              processingCount: props.processingCount,
              cartsCount: props.cartsCount
            }} 
            link={it}
            />
          })}

          </div>
          <div className={classes.sectionMobile}>
            <IconButton
              aria-label="show more"
              aria-controls={mobileMenuId}
              aria-haspopup="true"
              onClick={handleMobileMenuOpen}
              color="inherit"
            >
              <MoreIcon />
            </IconButton>
          </div>
        </Toolbar>
      </AppBar>

      <Grid container justify={"flex-end"}>
        <Grid item xs={12} md={8}>
          <SearchForm submitSearch={props.handleSubmitSearch}/>
         </Grid>
      </Grid>
      {renderMobileMenu}
      {renderMenu}
    </div></div>
  );
}

class Navbar extends React.Component {
  
  constructor(props){
    super(props)
    this.props.fetch(this.props.query(this.props.queryVars))
  }

  render(){

    return <div className="noPrint">
      <MainNavbar {...this.props} handleSubmitSearch={this.handleSubmitSearch.bind(this)}/>
      </div>
  }

  handleSubmitSearch(){
    let url = "/search/LIKE_" + this.props.search + "/" + this.props.searchfilter
    this.props.history.push(url)
  }
}

Navbar.propTypes = {
  theme: PropTypes.object.isRequired,
  fetch: PropTypes.func,
};

const mapStateToProps = (state)=>{
  return {
    query: state.application.query,
    queryVars: state.application.query,
    viewer: state.viewer,
    links: state.application.links,
    searchfilters: state.application.searchfilters,
    browse: state.application.browse,
    cptitles: state.application.cptitles,
    search: state.application.search,
    searchfilter: state.application.searchfilter,
    cart: state.cart.open
       }
  }
  
  const mapDispatchToProps = dispatch => {
    return {
      fetch: (query) => {
        dispatch(actions.application.APP_GET.creator(query))
      },
      toggleCart: () => {
        dispatch(actions.cart.TOGGLE_CART.creator())
      }
    }
  }  

  export default withTheme(withRouter(connect(mapStateToProps, mapDispatchToProps)(Navbar)))