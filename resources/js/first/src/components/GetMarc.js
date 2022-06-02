import React, { Component } from 'react';
import { connect } from 'react-redux'
import PropTypes from 'prop-types';
import actions from '../actions';
import Button from './Button'
import CircularProgress from '@material-ui/core/CircularProgress';
import { Link } from "react-router-dom";
import styles from "../styles.js"

class GetMarc extends Component{

    render(){ 
      if(this.props.marcLink === null || this.props.marcLink === undefined){
        
        let message = ''
        if(this.props.isbns.length === 1){
          message = "Download MARC record."
        }else{
          message = "Download all " + this.props.isbns.length + " MARC records."
        }
        return (<div style={{display:"flex", justifyContent:"flex-start"}}>
          <div>{message}: <Button variant="outlined" className={styles.getMarc} onClick={(e)=>{this.props.downloadAllMarcs({isbns:this.props.isbns, text:false})}}>.MRC</Button>
          </div>
          <Button variant="outlined" className={styles.getMarc} onClick={(e)=>{this.props.downloadAllMarcs({isbns:this.props.isbns, text:true})}}>.TXT</Button>
          </div>)
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