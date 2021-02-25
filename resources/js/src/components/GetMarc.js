import React, { Component } from 'react';
import { connect } from 'react-redux'
import PropTypes from 'prop-types';
import actions from '../actions';
import {Button} from '@material-ui/core';
import CircularProgress from '@material-ui/core/CircularProgress';
import { Link } from "react-router-dom";

class GetMarc extends Component{

    render(){ 
      
      if(this.props.marcLink === null || this.props.marcLink === undefined){
        return <Button color="primary" variant="outlined" style={{clear:"both", display:"block", width:"100%", margin:"25px"}} onClick={(e)=>{this.props.downloadAllMarcs({isbns:this.props.isbns})}}>{"BUILD ZIP FILE OF ALL " + this.props.isbns.length + " Marcs"}</Button>
      }else{
        return <a style={{clear:"both", display:"block", width:"90%", border:"solid 1px red", margin:"15px 0 15px 0", padding:"25px", textAlign:"center"}} href={this.props.marcLink}>Click to DOWNLOAD Zip file of Marc Records</a>
      }     
  }    
}

GetMarc.propTypes = {
    isbns: PropTypes.array
  };

const mapStateToProps = (state)=>{
return {
    marcLink: state.application.marcLink
     }
}

const mapDispatchToProps = dispatch => {
    return {
      downloadAllMarcs: (vars) => {
        dispatch(actions.form.DOWNLOAD_ALL_MARCS.creator(vars))
      }
    }
  }

export default connect(mapStateToProps, mapDispatchToProps)(GetMarc)