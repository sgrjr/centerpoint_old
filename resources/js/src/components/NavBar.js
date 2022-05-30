import React from 'react';
import Grid from '@material-ui/core/Grid';
import AppBar from '@material-ui/core/AppBar';
import Toolbar from '@material-ui/core/Toolbar';
import IconButton from '@material-ui/core/IconButton';
import Typography from '@material-ui/core/Typography';
import Button from './Button';
import MenuItem from '@material-ui/core/MenuItem';
import Menu from '@material-ui/core/Menu';
import IconPicker from '../components/IconPicker'
import Drawer from '@material-ui/core/Drawer';
import { Link, useParams, useNavigate } from "react-router-dom";
import { connect } from 'react-redux'
import PropTypes from 'prop-types';
import BrowseProducts from './BrowseProducts'
import SearchForm from './SearchForm'
import actions from '../actions';
import CustomMenuLink from './CustomMenuLink'
import Cart from '../Cart/Cart'

import {withTheme} from '@material-ui/core/styles'
//fix this to dynamic some time
import useStyles from './NavbarStyle.js'
import './NavBar.scss';
import styles from '../styles.js'

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

  if(props.viewer !== undefined && props.viewer.application !== undefined && props.viewer.application !== null && props.viewer.application.links){
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
        return <Link key={index} to={it.url}><MenuItem onClick={handleMenuClose} className="block">{it.text}</MenuItem></Link>
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
        toggleDrawer={menuToggle.bind(this)}
        />
      })}
    </Menu>
  );

  let shoppingCart = null
  let cart = null
              
    if(props.viewer.vendor && props.viewer.pending !== true && props.viewer.cart){
      shoppingCart = (<IconButton
      className={classes.menuButton}
      aria-label="open drawer"
      onClick={props.toggleCart}
    ><IconPicker icon="shoppingCartOutlined" /></IconButton>)


      cart = (<Drawer anchor={"right"} open={props.viewer.cart.open} onClose={props.toggleCart}>
        <Button onClick={props.toggleCart} startIcon={<IconPicker icon="minimize" />}>
        <IconPicker icon="shoppingCart" />
        </Button>
        <Cart navigate={props.navigate} closeDrawer={props.toggleCart}/>
      </Drawer>)

    }

  return (
      <div className={styles.mainNavigation + " " + props.mainClass}>
      
      {cart}

        <header>
          <Typography className={classes.title} noWrap>
            {/*<img src={"/img/original/logo.png"} style={{margin:"auto", display:"block", height:"100%"}} alt="logo"/>*/}
          </Typography>

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
          <div>{shoppingCart}</div>
          <div className={classes.sectionMobile}>
            <IconButton
              aria-label="show more"
              aria-controls={mobileMenuId}
              aria-haspopup="true"
              onClick={handleMobileMenuOpen}
              color="inherit"
            >
              <IconPicker icon="expand" />

            </IconButton>
          </div>
        </header>

       <SearchForm submitSearch={props.handleSubmitSearch} params={props.params}/>

      {renderMobileMenu}
      {renderMenu}

      <ul className="quick-links">

        <li><BrowseProducts browse={props.browse} open={false}/></li>

      {links.shortCuts && links.shortCuts.map(function(it,index){
            return <li key={index}><Link to={it.url}>{it.text}</Link></li>
          })}
          </ul>
    </div>
  );
}

class Navbar extends React.Component {
  
  constructor(props){
    super(props)
    this.props.fetch(this.props.query(this.props.queryVars))
  }

  render(){
    return <MainNavbar {...this.props} handleSubmitSearch={this.handleSubmitSearch.bind(this)}/>
  }

  handleSubmitSearch(){
    let url = "/search/" + this.props.search + "/" + this.props.searchFilter
    this.props.navigate(url)
  }
}

Navbar.propTypes = {
  theme: PropTypes.object.isRequired,
  fetch: PropTypes.func,
};

const mapStateToProps = (state)=>{
  return {
    browse: state.application.browse,
    query: state.application.query,
    queryVars: state.application.query,
    viewer: state.viewer,
    links: state.application.links,
    searchFilters: state.application.searchFilters,
    browse: state.application.browse,
    cptitles: state.application.cptitles,
    search: state.application.search,
    searchFilter: state.application.searchFilter,
    oldWebsite: state.application.oldWebsite
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

const NavbarWithParams = (props) => {
  return <Navbar {...props} params={useParams()} navigate={useNavigate()}/>
}

  export default withTheme(connect(mapStateToProps, mapDispatchToProps)(NavbarWithParams))