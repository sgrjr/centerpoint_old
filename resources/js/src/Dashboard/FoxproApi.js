import React, { Component } from 'react';
import { Link } from "react-router-dom";
import actions from '../actions';
import { connect } from 'react-redux'
import { withStyles } from '@material-ui/core/styles';
import Table from '@material-ui/core/Table';
import TableBody from '@material-ui/core/TableBody';
import TableCell from '@material-ui/core/TableCell';
import TableHead from '@material-ui/core/TableHead';
import TableRow from '@material-ui/core/TableRow';
import {Navigate } from 'react-router-dom';
import IconPicker from '../components/IconPicker'

const useStyles = (theme => ({
  seeMore: {
    marginTop: theme.spacing(3),
  },
}));

class FoxproApi extends Component {

   constructor(props){
    super(props);

    this.state = {
      url:"https://centerpointlargeprint.com/foxisapi/foxisapi.dll/webnet.gate.startpoint",
      opts: {
        method:"POST",
        headers: {
          'Content-type': 'application/x-www-form-urlencoded'
        }
      }

    }
   }

    componentDidMount(){
      //this.login()
    }

  render(){
    return <div/>
  return (
  <div><div dangerouslySetInnerHTML={{ __html: this.props.admin.data.foxpro }} /><button onClick={()=>{this.deleteShoppingCart()}}>DELETE SHOPPING CART</button></div>
  );
}

  deleteShoppingCart(){
    const params = {
        bzp: "ACCOUNT_LOG_KILL_SHOPCART",
        z01:"stephenreynolds",
        z02:"sunshine",
        z03:"0498600000003",
        z04:67035,
        HEADER_FILE:"WEBHEAD",
        DETAIL_FILE:"WEBDETAIL",
        NEW_ERROR_INFO:"Alert+&Welcome+to+the+Center+Point+website.&"
      }

     this.props.queryFoxpro(this.state.url, params, this.state.opts) 
    }

  getShoppingCart(){
     const params = {
        bzp:"GENERAL_VIEW",
        z01:"stephenreynolds",
        z02:"sunshine",
        z03:"0498600000003",
        z04:"67035",
        HEADER_FILE:"WEBHEAD",
        DETAIL_FILE:"WEBDETAIL",
        ORDER_TRANSNO:""
      }

    this.props.queryFoxpro(this.state.url, params, this.state.opts) 
  }

  login(){
    const params = {
        x: 0,
        y: 0,
        THISUSERNAME: "stephenreynolds",
        THISPASSWORD: "sunshine",
        USEARZZINP: "",
        USETIZZINP: "",
        bzp: "TD_TITLE_VIEW",
        RETURNPAGE: "TD_TITLE_VIEW",
        PASSZREC: "",
        SEARCHBY: "BYAUTHORS",
        SORTBY: "",
        MULTIBUY: "",
        FULLVIEW: "",
        SKIPBOUGHT: "",
        OUTOFPRINT: "",
        OPROCESS: "",
        OADDTL: "",
        OVIEW: "",
        ORHIST: "",
        INSOS: "",
        INREG: "",
        OINVO: "",
        EXTZN: "",
        OBEST: "",
        ADVERTISE: "",
        DEFAULTPER: ""
      }

      this.props.queryFoxpro(this.state.url, params, this.state.opts) 
  }

}

const mapStateToProps = (state)=>{
return {
    admin: state.admin
     }
}

const mapDispatchToProps = dispatch => {
    return {
      queryFoxpro: (url, params, options) => {
        dispatch(actions.admin.ADMIN_GET_FOXPRO.creator(url, params, options))
      }
    }
  }

export default connect(mapStateToProps, mapDispatchToProps)(withStyles(useStyles)(FoxproApi))


/*

      const xhttp = new XMLHttpRequest();
      xhttp.onload = function() {
        document.getElementById("demo").innerHTML = this.responseText;
        console.log(this)
        }
      xhttp.open("post", "https://centerpointlargeprint.com/foxisapi/foxisapi.dll/webnet.gate.startpoint", true);

      //bzp%3DMAINMENU%26z01%3Dstephenreynolds%26z02%3Dsunshine%26z03%3D0498600000003%26z04%3D67035%26HEADER_FILE%3DWEBHEAD%26DETAIL_FILE%3DWEBDETAIL%26ORDER_TRANSNO%3D%26

      const bzp = [
        "GENERAL_VIEW",
        ""
      ];
      const params = 'bzp=GENERAL_VIEW%26z01=stephenreynolds%26z02=sunshine%26z03=0498600000003%26z04=67035%26HEADER_FILE=WEBHEAD%26DETAIL_FILE=WEBDETAIL%26ORDER_TRANSNO=%26'

      xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');            

      xhttp.send(params);

*/