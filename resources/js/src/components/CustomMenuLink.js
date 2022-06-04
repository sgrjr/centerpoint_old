import React from 'react';
import MenuItem from '@material-ui/core/MenuItem';
import IconButton from '@material-ui/core/IconButton';
import Badge from '@material-ui/core/Badge';
import PropTypes from 'prop-types';
import IconPicker from './IconPicker'
import { Link } from "react-router-dom";
import Divider from '@material-ui/core/Divider';

class CustomMenuLink extends React.Component {

  render(){

    const {link, toggleDrawer, classes, data} = this.props

    switch(link.icon){

      case 'notifications':
        return (<MenuItem className={classes.menuItem} style={{marginRight: "15px"}}>
                <Link to={link.url}>
                  <Badge badgeContent={data.processingCount}>
                  <IconPicker icon={link.icon}/>
                  </Badge>
                  {link.text}
                </Link>
          </MenuItem>)

        case 'shoppingCart':
          return (<MenuItem className={classes.menuItem}>

            <IconButton 
                aria-label="show 17 new notifications" 
                color="inherit"
                edge="start"
                className={classes.menuButton}
                onClick={toggleDrawer}
                >
                    <Badge badgeContent={data.cartsCount} color="secondary">
                    <IconPicker icon={link.icon}/>
                    </Badge>
                  </IconButton>
            </MenuItem>)
      
      case "HEADING":
          return (<MenuItem className={classes.menuItem}>
            <Divider />
            <h2>{link.text}</h2>
          </MenuItem>)
      default:

        return (<Link to={link.url}><MenuItem className={classes.menuItem} style={{marginRight: "15px"}}>
                  <IconPicker icon={link.icon}/>
                  {link.text}
          </MenuItem></Link>)

    }
  }
}

CustomMenuLink.propTypes = {
  handleProfileMenuOpen: PropTypes.func,
  link: PropTypes.object,
  classes: PropTypes.object,
  toggleDrawer: PropTypes.func,
  data: PropTypes.object
};  

export default CustomMenuLink