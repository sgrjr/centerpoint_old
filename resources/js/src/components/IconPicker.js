import React from 'react';
import PropTypes from 'prop-types';

import NotificationsIcon from '@material-ui/icons/Notifications';
import AccountCircleIcon from '@material-ui/icons/AccountCircle';
import ShoppingCartIcon from '@material-ui/icons/ShoppingCart';
import DashboardIcon from '@material-ui/icons/Dashboard';
import LockOpenIcon from '@material-ui/icons/LockOpen';
import LockIcon from '@material-ui/icons/Lock';
import HowToRegIcon from '@material-ui/icons/HowToReg';
import HomeIcon from '@material-ui/icons/Home';

class IconPicker extends React.Component {

  render(){

    const icons = {
      shoppingCart: <ShoppingCartIcon />,
      notifications: <NotificationsIcon/>,
      accountCircle: <AccountCircleIcon/>,
      none : <span />,
      dashboard: <DashboardIcon/>,
      lockOpen: <LockOpenIcon/>,
      lock: <LockIcon/>,
      howToReg: <HowToRegIcon/>,
      home: <HomeIcon/>,
      HEADING: <span/>,
      person: <AccountCircleIcon/>
    }
    if(this.props.name !== undefined && icons[this.props.name] !== undefined){
      return icons[this.props.name]
    }else{
      return null
    }
      
  }
}

IconPicker.propTypes = {
  name: PropTypes.string,
};  

export default IconPicker