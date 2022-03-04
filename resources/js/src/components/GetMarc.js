import React, { Component } from 'react';
import { connect } from 'react-redux'
import PropTypes from 'prop-types';
import actions from '../actions';
import {Button} from '@material-ui/core';
import CircularProgress from '@material-ui/core/CircularProgress';
import { Link } from "react-router-dom";
import styles from "../styles.js"

class GetMarc extends Component{

    render(){ 
      if(this.props.marcLink === null || this.props.marcLink === undefined){
        
        let message = ''
        if(this.props.isbns.length === 1){
          message = "BUILD ZIP FILE OF MARC record."
        }else{
          message = "BUILD ZIP FILE OF ALL " + this.props.isbns.length + " MARC records."
        }
        return <button className={styles.getMarc + " outlined"} onClick={(e)=>{this.props.downloadAllMarcs({isbns:this.props.isbns})}}>{message}</button>
      }else{
        let url = this.props.marcLink
        window.open(url)
        
        setTimeout(this.props.clearMarc, 1000)

        return <a style={{clear:"both", display:"block", width:"90%", border:"solid 1px red", margin:"15px 0 15px 0", padding:"25px", textAlign:"center"}} href={url}>If download doesn't start, click here.</a>
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
      },
      clearMarc: (vars) => {
        dispatch(actions.form.CLEAR_MARC.creator(vars))
      }
    }
  }

export default connect(mapStateToProps, mapDispatchToProps)(GetMarc)