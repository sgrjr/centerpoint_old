import React, { useRef, useState} from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux'
import ToggleWebsite from './ToggleWebsite'

const OldWebsite = function(props) {

   return (
   	<div id="old-website" style={{display:"flex", flexDirection:"column"}}>
   	  <ToggleWebsite />
  	  <iframe
        src={props.src}
        style={{ width: '1px', minWidth: '1492px', margin:"auto", minHeight:"100%", height:"2000px"}}
      ></iframe></div>
  );
}

OldWebsite.propTypes = {
  src: !PropTypes.string
};

const mapStateToProps = (state)=>{
  return {}
 }
  
export default connect(mapStateToProps)(OldWebsite)