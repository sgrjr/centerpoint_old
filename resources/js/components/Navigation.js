import React, { Component } from 'react';
import ReactDOM from 'react-dom';

export default class Navigation extends Component {

    componentWillMount(){

    }

    render() {
     
      let { search,  titleCategories, searchCategory, links, processing_count, carts_count} = this.setDefaults()
      let csrf = this.props.csrf

    return (

   <nav id="main-nav" className="navbar navbar-expand">

      <div id="search" className="search-form">
       <div className="search">
            <form method="POST" action="/search">
              <input type="hidden" name="_token" value={csrf}>
              <div className="inner-form">
                <div className="input-field first-wrap">
                  <input id="search" type="text" name="string" type="search" placeholder={search} />
                </div>
                <div className="input-field second-wrap">

                    <select data-trigger="" name="search_categories">
                      <option placeholder="">TITLE</option>

                        {titleCategories.map(function(col){

                          if(searchCategory !== undefiend && col === searchCategory){
                            return <option value={col} selected>{col}</option>
                          }else{
                            return <option value={col}>{col}</option>
                          }

                        })}
        
                    </select>

                </div>
                <div className="input-field third-wrap">
                  <button className="btn-search" type="submit"><i className="fas fa-search"></i></button>
                </div>
              </div>
            </form>
          </div>
      </div>

        <div id="brand">
          <a className="navbar-brand" href="/">
            <img src="/img/logo.png" />
          </a>
        </div>

      <div className="" id="navigation">
        <ul className="navbar-nav">

         {links.map(function(link){

            switch(link.name){

              case "dashboard":
                return <li className="nav-item"><a className="nav-link" href={link.path}>{link.title} <span className="badge badge-info">{processing_count}</span></a></li>;
                break;

              case "cart":
                return  <li className="nav-item"><a id="shopping-cart" className="nav-link" href={link.path}>{link.title} <span className="badge badge-info">{carts_count}</span></a></li>
                break;

              default:
                return <li className="nav-item"><a className="nav-link" href={link.path}>{link.title}</a></li>;
            }

          })}
          
        </ul>
      </div>
    </nav>
  
    

              );
            }

            setDefaults(props){

              let vals = {
                search: "Search by title...",
                titleCategories: [],
                searchCategory: "title",
                links: [],
                processing_count: 0,
                carts_count:0
              }

              this.props.user.forEach(function(v,k){
                if(v !== undefined){
                  vals[k] = v
                }
              })
             
             return vals
            }

 }