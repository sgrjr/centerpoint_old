import React from 'react';
import IconButton from '@material-ui/core/IconButton';
import Menu from '@material-ui/core/Menu';
import MenuItem from '@material-ui/core/MenuItem';
import IconPicker from '../components/IconPicker'
import {
  Link
} from "react-router-dom";
import Divider from '@material-ui/core/Divider';
import PropTypes from 'prop-types';
import CircularProgress from '@material-ui/core/CircularProgress';

const ITEM_HEIGHT = 42;

const TitleList = (props) => {

    return  (<>

        <h2>{props.list.title}</h2>
        
        {props.list.items.map(function(item, index){
          return (<li key={index} onClick={props.handleClose}>
          <Link style={{color:"inherit"}} to={item.url}>{item.text}</Link>
        </li>)
        })}
 
      <Divider light />
    </>);

}

const LongMenu = (props) =>{
  const [anchorEl, setAnchorEl] = React.useState(null);
  const open = Boolean(anchorEl);

  const handleClick = (event) => {
    setAnchorEl(event.currentTarget);
  };

  const handleClose = (event) => {
    setAnchorEl(null);
  };

  return (
    <React.Fragment>
      <span onClick={handleClick}><IconPicker icon={"moreVertical"} />Browse</span>
      <Menu
        id="long-menu"
        anchorEl={anchorEl}
        open={open}
        onClose={handleClose}
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
          return <TitleList key={index} list={list} handleClose={null}/>
      })}
    </ul>
  );
}

class BrowseProducts extends React.Component {

  render(){
    if(!this.props.browse || this.props.browse.length <= 0){
      return <div style={{with:"50%", margin:"auto", textAlign:"center"}}><CircularProgress color="primary"/></div>;
    }else if(this.props.open){
      return <JustBrowse {...this.props}/>
    }else{
      return <LongMenu {...this.props}/>
    }
    
  }
}

BrowseProducts.propTypes = {
  browse: PropTypes.array
};
  
  export default BrowseProducts;