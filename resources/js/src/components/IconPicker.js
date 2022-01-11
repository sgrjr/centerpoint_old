import React from 'react';
import PropTypes from 'prop-types';

import AccountCircleIcon from '@mui/icons-material/AccountCircle';
import AddIcon from '@mui/icons-material/Add'
import BackIcon from "@mui/icons-material/ArrowBackIos"
import BooksIcon from "@mui/icons-material/LibraryBooks"
import CalendarIcon from '@mui/icons-material/CalendarToday'
import ChevronLeftIcon from '@mui/icons-material/ChevronLeft';
import ChevronRightIcon from "@mui/icons-material/ChevronRight"
import ClearIcon from '@mui/icons-material/Clear'
import CreateIcon from '@mui/icons-material/Create'
import DashboardIcon from '@mui/icons-material/Dashboard';
import DeleteIcon from '@mui/icons-material/Delete'
import EditIcon from '@mui/icons-material/Edit'
import ExpandIcon from '@mui/icons-material/ExpandMore'
import ForwardIcon from "@mui/icons-material/ArrowForwardIos"
import HowToRegIcon from '@mui/icons-material/HowToReg';
import HomeIcon from '@mui/icons-material/Home';
import InventoryIcon from '@mui/icons-material/Inventory';
import LoginIcon from '@mui/icons-material/Login';
import LockIcon from '@mui/icons-material/Lock';
import LockOpenIcon from '@mui/icons-material/LockOpen';
import LockOutlinedIcon from "@mui/icons-material/LockOutlined";
import MoreVerticalIcon from '@mui/icons-material/MoreVert';
import NavigateBeforeIcon from '@mui/icons-material/NavigateBefore'
import NavigateNextIcon from '@mui/icons-material/NavigateNext'
import NotificationsIcon from '@mui/icons-material/Notifications';
import PaidIcon from "@mui/icons-material/Paid"
import PersonSearch from '@mui/icons-material/PersonSearch';
import PawIcon from '@mui/icons-material/Pets'
import PrintIcon from '@mui/icons-material/Print'
import RestartIcon from "@mui/icons-material/RestartAlt"
import SearchIcon from '@mui/icons-material/Search';
import SettingsIcon from "@mui/icons-material/Settings"
import ShoppingCartIcon from '@mui/icons-material/ShoppingCart';
import ShoppingCartOutlinedIcon from '@mui/icons-material/ShoppingCartOutlined';
import ShoppingCartAddIcon from '@mui/icons-material/AddShoppingCart';
import ShoppingCartRemoveIcon from '@mui/icons-material/RemoveShoppingCart';
import StoreIcon from "@mui/icons-material/Store"

class IconPicker extends React.Component {

  render(){

    const icons = {
      accountCircle: <AccountCircleIcon/>,
      add: <AddIcon />,
      back: <BackIcon/>,
      books: <BooksIcon/>,
      calendar: <CalendarIcon/>,
      chevronLeft: <ChevronLeftIcon/>,
      chevronRight: <ChevronRightIcon/>,
      clear: <ClearIcon/>,
      create: <CreateIcon />,
      dashboard: <DashboardIcon/>,
      delete: <DeleteIcon />,
      edit: <EditIcon/>,
      expand: <ExpandIcon />,
      forward: <ForwardIcon/>,
      HEADING: <span/>,
      home: <HomeIcon/>,
      howToReg: <HowToRegIcon/>,
      inventory: <InventoryIcon/>,
      lock: <LockIcon/>,
      lockOpen: <LockOpenIcon/>,
      lockOutlined: <LockOutlinedIcon/>,
      login: <LoginIcon />,
      moreVertical: <MoreVerticalIcon/>,
      none : <span />,
      navigateNext: <NavigateNextIcon/>,
      navigateBefore: <NavigateBeforeIcon/>,
      notifications: <NotificationsIcon/>,
      paid: <PaidIcon/>,
      person: <AccountCircleIcon/>,
      personSearch: <PersonSearch/>,
      paw: <PawIcon/>,
      print: <PrintIcon/>,
      restart: <RestartIcon/>,
      search: <SearchIcon />,
      settings: <SettingsIcon/>,
      shoppingCart: <ShoppingCartIcon />,
      shoppingCartAdd: <ShoppingCartAddIcon />,
      shoppingCartOutlined: <ShoppingCartOutlinedIcon/>,
      shoppingCartRemove: <ShoppingCartRemoveIcon />,
      store: <StoreIcon/>
    }

    if(this.props.name !== undefined && icons[this.props.name] !== undefined){
      return icons[this.props.name]
    }else{
      console.log('missing icon => ', this.props.name, this.props)
      return null
    }
      
  }
}

IconPicker.propTypes = {
  name: PropTypes.string,
};  

export default IconPicker