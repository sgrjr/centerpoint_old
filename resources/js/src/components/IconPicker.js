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
import CloseFullscreenIcon from '@mui/icons-material/CloseFullscreen';
import CreateIcon from '@mui/icons-material/Create'
import DashboardIcon from '@mui/icons-material/Dashboard';
import DeleteIcon from '@mui/icons-material/Delete'
import EditIcon from '@mui/icons-material/Edit'
import ExpandIcon from '@mui/icons-material/ExpandMore'
import ForwardIcon from "@mui/icons-material/ArrowForwardIos"
import FullscreenIcon from "@mui/icons-material/Fullscreen"
import HowToRegIcon from '@mui/icons-material/HowToReg';
import HomeIcon from '@mui/icons-material/Home';
import InventoryIcon from '@mui/icons-material/Inventory';
import LoginIcon from '@mui/icons-material/Login';
import LockIcon from '@mui/icons-material/Lock';
import LockOpenIcon from '@mui/icons-material/LockOpen';
import LockOutlinedIcon from "@mui/icons-material/LockOutlined";
import MinimizeIcon from '@mui/icons-material/Minimize';
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
import SendIcon from '@mui/icons-material/Send';
import SettingsIcon from "@mui/icons-material/Settings"
import ShoppingCartIcon from '@mui/icons-material/ShoppingCart';
import ShoppingCartOutlinedIcon from '@mui/icons-material/ShoppingCartOutlined';
import ShoppingCartAddIcon from '@mui/icons-material/AddShoppingCart';
import ShoppingCartRemoveIcon from '@mui/icons-material/RemoveShoppingCart';
import ShoppingCartCheckoutIcon  from '@mui/icons-material/ShoppingCartCheckout';
import StoreIcon from "@mui/icons-material/Store"

class IconPicker extends React.Component {

  render(){
    const style = {
      fontSize: "unset"
    }

    const icons = {
      accountCircle: <AccountCircleIcon style={style}/>,
      add: <AddIcon style={style}/>,
      back: <BackIcon style={style}/>,
      books: <BooksIcon style={style}/>,
      calendar: <CalendarIcon style={style}/>,
      chevronLeft: <ChevronLeftIcon style={style}/>,
      chevronRight: <ChevronRightIcon style={style}/>,
      clear: <ClearIcon style={style}/>,
      create: <CreateIcon style={style}/>,
      dashboard: <DashboardIcon style={style}/>,
      delete: <DeleteIcon style={style}/>,
      edit: <EditIcon style={style}/>,
      expand: <ExpandIcon style={style}/>,
      forward: <ForwardIcon style={style}/>,
      fullScreen: <FullscreenIcon style={style}/>,
      HEADING: <span/>,
      home: <HomeIcon style={style}/>,
      howToReg: <HowToRegIcon style={style}/>,
      inventory: <InventoryIcon style={style}/>,
      lock: <LockIcon style={style}/>,
      lockOpen: <LockOpenIcon style={style}/>,
      lockOutlined: <LockOutlinedIcon style={style}/>,
      login: <LoginIcon style={style}/>,
      close: <CloseFullscreenIcon style={style}/>,
      minimize: <MinimizeIcon style={style}/>,
      moreVertical: <MoreVerticalIcon style={style}/>,
      none : <span />,
      navigateNext: <NavigateNextIcon style={style}/>,
      navigateBefore: <NavigateBeforeIcon style={style}/>,
      notifications: <NotificationsIcon style={style}/>,
      paid: <PaidIcon style={style}/>,
      person: <AccountCircleIcon style={style}/>,
      personSearch: <PersonSearch style={style}/>,
      paw: <PawIcon style={style}/>,
      print: <PrintIcon style={style}/>,
      restart: <RestartIcon style={style}/>,
      search: <SearchIcon style={style}/>,
      send: <SendIcon style={style}/>,
      settings: <SettingsIcon style={style}/>,
      shoppingCart: <ShoppingCartIcon style={style}/>,
      shoppingCartAdd: <ShoppingCartAddIcon style={style}/>,
      shoppingCartOutlined: <ShoppingCartOutlinedIcon style={style}/>,
      shoppingCartRemove: <ShoppingCartRemoveIcon style={style}/>,
      shoppingCartCheckout: <ShoppingCartCheckoutIcon style={style}/>,
      store: <StoreIcon style={style}/>,
    }

    if(this.props.icon !== undefined && icons[this.props.icon] !== undefined){
      return icons[this.props.icon]
    }else{
      console.log('missing icon => ', this.props.icon, this.props)
      return null
    }
      
  }
}

IconPicker.propTypes = {
  icon: PropTypes.string,
};  

export default IconPicker