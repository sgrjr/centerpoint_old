import React, { Component } from 'react';
import ReactDOM from 'react-dom';

export default class Sidebar extends Component {

    render() {
//themify
      let icons = {
        dashboard : "ti-dashboard",
        cart : "ti-shopping-cart",
        login : "ti-layout-list-post",
        logout : "ti-lock",
        login : "ti-unlock",
        register : "ti-pencil",
        adminvendors : "ti-user",
        admininventories : "ti-write",
        same : "ti-bookmark-alt",
        adminapplication : "ti-pin",
        adminorders : "ti-start",
        profile : "ti-setttings",
        settings : "ti-info",
        admindb : "ti-folder",
        home : "ti-home",
        db :"ti-shield",
        undefined: "ti-loop"

      }

    return (

  <nav className="sidebar sidebar-offcanvas" id="sidebar">

        <ul className="nav">

            {this.props.links.map(function(link, key){



              if(link.url === null){
                return <h2 key={key}>{link.text}</h2>
              }else{

                let ico = link.url.replace("http://localhost","")
                .replace("http://dev.centerpointlargeprint.com","")
                .toLowerCase().replace(/\s/g, '')
                .replace(/\s/g, '')
                .replace(/\//g, '')

              if(ico == ""){
                ico = "home"
              }else if(ico == "#"){
                ico = "same"
              }

              return (<li key={key}className="nav-item">
                <a className="nav-link" href={link.url}>
                  <i className={ icons[ico] + " menu-icon"}></i>
                  <span className="menu-title">{link.text}</span>
                </a>
              </li>)
              }

             })}


          <li className="nav-item">
            <a className="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <i className="ti-palette menu-icon"></i>
              <span className="menu-title">UI Elements</span>
              <i className="menu-arrow"></i>
            </a>
            <div className="collapse" id="ui-basic">
              <ul className="nav flex-column sub-menu">
                <li className="nav-item"> <a className="nav-link" href="pages/ui-features/buttons.html">Buttons</a></li>
                <li className="nav-item"> <a className="nav-link" href="pages/ui-features/typography.html">Typography</a></li>
              </ul>
            </div>
          </li>
          <li className="nav-item">
            <a className="nav-link" href="pages/forms/basic_elements.html">
              <i className="ti-layout-list-post menu-icon"></i>
              <span className="menu-title">Form elements</span>
            </a>
          </li>
          <li className="nav-item">
            <a className="nav-link" href="pages/charts/chartjs.html">
              <i className="ti-pie-chart menu-icon"></i>
              <span className="menu-title">Charts</span>
            </a>
          </li>
          <li className="nav-item">
            <a className="nav-link" href="pages/tables/basic-table.html">
              <i className="ti-view-list-alt menu-icon"></i>
              <span className="menu-title">Tables</span>
            </a>
          </li>
          <li className="nav-item">
            <a className="nav-link" href="pages/icons/themify.html">
              <i className="ti-star menu-icon"></i>
              <span className="menu-title">Icons</span>
            </a>
          </li>
          <li className="nav-item">
            <a className="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
              <i className="ti-user menu-icon"></i>
              <span className="menu-title">User Pages</span>
              <i className="menu-arrow"></i>
            </a>
            <div className="collapse" id="auth">
              <ul className="nav flex-column sub-menu">
                <li className="nav-item"> <a className="nav-link" href="pages/samples/login.html"> Login </a></li>
                <li className="nav-item"> <a className="nav-link" href="pages/samples/login-2.html"> Login 2 </a></li>
                <li className="nav-item"> <a className="nav-link" href="pages/samples/register.html"> Register </a></li>
                <li className="nav-item"> <a className="nav-link" href="pages/samples/register-2.html"> Register 2 </a></li>
                <li className="nav-item"> <a className="nav-link" href="pages/samples/lock-screen.html"> Lockscreen </a></li>
              </ul>
            </div>
          </li>
          <li className="nav-item">
            <a className="nav-link" href="documentation/documentation.html">
              <i className="ti-write menu-icon"></i>
              <span className="menu-title">Documentation</span>
            </a>
          </li>
        </ul>
      </nav>
    );
            }

 }