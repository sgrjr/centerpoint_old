import React, { Component } from 'react';
import ReactDOM from 'react-dom';

import Nav from './Nav'
import Footer from './Footer'
import Sidebar from './Sidebar'
import Loading from './Loading'

export default class Dashboard extends Component {

    render() {
      let links = []
      let ready = this.props.isLoaded

      if (this.props.links !== undefined){
        links = this.props.links
      }

    return (

      <div className="container-scroller">

        <Nav user={this.props.user}/>

          <div className="container-fluid page-body-wrapper">

            <Sidebar links={links}/>

            <div className="main-panel">
        
                <div className="content-wrapper">

<div className="d-flex flex-row bd-highlight justify-content-center align-self-center mb-3 flex-wrap">
                {this.props.widgets.map(function(w, k){

                  if(w.show){
                  switch(w.type){

                    case "card":

                      return (
                      
                        <div key={k} className={w.rowClass}>
                          <div className="card position-relative">
                            <div className="card-body">
                              <p className="card-title">{w.title}</p>
                                  <Loading ready={ready} />
                                  {w.component}
                            </div>
                          </div>
                        </div>
                      
                      )

                      break;

                    default:

                      return (
 
                          <div key={k} className={w.rowClass}>
                              {w.component}
                          </div>

                        )
                    }
                  }
                })} 
                </div>      
                </div>
              <Footer />

          </div>

        </div>

      </div>
     );
            }

 }