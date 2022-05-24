import React, { Component } from 'react';

export default class StandingOrders extends Component {

    render() {


      if(this.props.data.activeSo !== undefined){


      return (<div className={this.props.cName}>

                  <ul>

                  {this.props.data.activeSo.map(function(so){
                    let style = {
                      color: so.color
                    }
                    return (<li style={style}>
                            {so.SOSERIES}  <b>DISCOUNT</b>: {so.DISC * 100} %
                      </li>);
                  })}
                  </ul>


            </div>
      );
  }else{
    return ""
  }
            }

 }