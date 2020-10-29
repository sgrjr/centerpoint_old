import React, { Component } from 'react';
import ReactDOM from 'react-dom';

export default class Menu extends Component {

  constructor(props) {
    super(props);

    this.state = {
      isClosed: true
    };

  }

    render() {
      let links = []
      let loading = <div className="spinner-border text-light" role="status">Loading...<span className="sr-only">Loading...</span></div>

      if (this.props.links !== undefined){
        links = this.props.links
      }

      if (this.props.links.length > 0){
       loading = null
      }

      let ostyle={}
      if(!this.state.isClosed){
        ostyle= {display: "block"}
      }

    return (

      <div id="wrapper" className={this.state.isClosed? "":"toggled"}>
      
       <div className="overlay" style={ostyle}></div>
          

        <nav id="sidebar-wrapper" role="navigation">

            <ul className="nav sidebar-nav">

            {loading}

              {links.map(function(link, id){

                  switch(link.name){
                    case 'brand':
                        return  <li key={id} className="sidebar-brand"><a href={link.url}>{link.text} <span className="caret"></span></a></li>
                      break;
                    case 'logout':
                        return  <li key={id} className="nav-item"><a href={link.url}><i className="fa fa-btn fa-sign-out"></i>{link.text}</a></li>
                      break;
                    case 'heading':
                      return <h6 key={id} className="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted"><span>{link.text}</span><a className="d-flex align-items-center text-muted" href="#"><span data-feather="plus-circle"></span> </a></h6>
                      break;
                    default:
                      return  <li key={id} className="nav-item"><a href={link.url}>{link.text}</a></li>

                  }

              })}
             
            </ul>
        </nav>

          <button type="button" className={this.state.isClosed? "hamburger is-closed":"hamburger is-open"} data-toggle="offcanvas" onClick={this.cross.bind(this)}>
            <span className="hamb-top"></span>
            <span className="hamb-middle"></span>
            <span className="hamb-bottom"></span>
          </button>
   </div>
    

              );
            }

    cross() {
      this.setState({isClosed: !this.state.isClosed})
    }

 }