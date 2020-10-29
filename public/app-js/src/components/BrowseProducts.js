import React from 'react';
import IconButton from '@material-ui/core/IconButton';
import Menu from '@material-ui/core/Menu';
import MenuItem from '@material-ui/core/MenuItem';
import MoreVertIcon from '@material-ui/icons/MoreVert';
import {
  Link
} from "react-router-dom";
import Divider from '@material-ui/core/Divider';
import PropTypes from 'prop-types';

const ITEM_HEIGHT = 42;

const TitleList = ({list, handleClose}) => {

    return  (<div>
        <h2>{list.title}</h2>
        
        
        {list.items.map(function(item, index){
          return (<MenuItem key={index} onClick={handleClose}>
          <Link style={{color:"inherit"}} to={item.url}>{item.text}</Link>
        </MenuItem>)
        })}
 
      <Divider light />
    </div>);

}

const LongMenu = (props) =>{
  const [anchorEl, setAnchorEl] = React.useState(null);
  const open = Boolean(anchorEl);

  const handleClick = event => {
    setAnchorEl(event.currentTarget);
  };

  const handleClose = () => {
    setAnchorEl(null);
  };

  return (
    <React.Fragment>
      <IconButton
        aria-label="more"
        aria-controls="long-menu"
        aria-haspopup="true"
        onClick={handleClick}
        style={{borderRadius:"unset", width:"100%"}}
      >
        Browse
        <MoreVertIcon />
      </IconButton>
      <Menu
        id="long-menu"
        anchorEl={anchorEl}
        open={open}
        onClose={handleClose}
        PaperProps={{
          style: {
            maxHeight: ITEM_HEIGHT * 8,
            width: 300,
            marginTop: "50px"
          },
        }}
      >
        {props.browse.map(function(list, index){
          return <TitleList key={index} list={list} handleClose={handleClose}/>
      })}
      </Menu>
    </React.Fragment>
  );
}

const JustBrowse = (props) =>{
  

  return (
    <ul>
        {props.browse.map(function(list, index){
          return <TitleList key={index} list={list} />
      })}
    </ul>
  );
}

class BrowseProducts extends React.Component {

  render(){
    if(this.props.open){
      return <JustBrowse {...this.props}/>
    }else{
      return <LongMenu {...this.props}/>
    }
    
  }
}

BrowseProducts.propTypes = {
  links: PropTypes.array
};
  
  export default BrowseProducts;