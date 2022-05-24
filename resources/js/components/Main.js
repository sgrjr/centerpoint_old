import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios'
import Menu from './Menu'
//import Navigation from './Navigation'
import Dashboard from './Dashboard'

import DashboardHeader from './Widgets/DashboardHeader'
import ProfileImage from './Widgets/ProfileImage'
import StandingOrders from './Widgets/StandingOrders'
import OrdersProcessing from './Widgets/OrdersProcessing'
import AvailableTitles from './Widgets/AvailableTitles'
import Purchases from './Widgets/Purchases'
import TopProducts from './Widgets/TopProducts'
import ToDoList from './Widgets/ToDoList'

export default class Main extends Component {

  constructor(props) {
    super(props);

    this.state = {
      error: null,
      isLoaded: false,

      data: {
        links:[],
        user: {},
      },
      token: props.token,
      csrf: props.csrf 
    };

  }

 componentDidMount() {
    this.getData()
  }

    render() {

         const { error, isLoaded, data, csrf } = this.state;

         const widg = [
        {
          title: "Dashboard",
          show: true,
          type: "min",
          rowClass:"row col-12 bg-white p-2",
          component: <DashboardHeader cName="col-12" {...this.state}/>
        },
        {
          title: "Profile Image",
          show: true,
          rowClass: "col-6 mb-2",
          type: "card",
          component: <ProfileImage cName="ml-xl-4"  {...this.state}/>
        },
        {
          title: "Contact Info",
          show: true,
          rowClass: "col-6 mb-2",
          type: "card",
          component: <div><h2>{this.state.data.user.name}</h2><h4>{this.state.data.user.email}</h4></div>
        },
        {
          title: "Standing Orders",
          show: true,
          rowClass: "col-6 mb-2",
          type: "card",
          component: <StandingOrders cName="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center" {...this.state}/>
        },
        {
          title: "Orders Procesing",
          show: true,
          rowClass: "col-6 mb-2",
          type: "card",
          component:  <OrdersProcessing cName="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center"  {...this.state}/>
        },
        {
          title: "Available Titles",
          show: true,
          rowClass: "col-6 mb-2",
          type: "card",
          component:  <AvailableTitles cName="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center"  {...this.state}/>
        },
        {
          title: "Purchases",
          show: true,
          rowClass: "col-6 mb-2",
          type: "card",
          component: <Purchases cName="d-flex flex-wrap mb-5"  {...this.state}/>
        },
        {
          title: "Top Products",
          show: true,
          rowClass: "col-6 mb-2",
          type: "card",
          component: <TopProducts cName="table-responsive"  {...this.state}/>
        },
        {
          title: "To Do List",
          show: true,
          rowClass: "col-6 mb-2",
          type: "card",
          component: <ToDoList cName=""  {...this.state}/>
        }
      ]

            if (error) {
              return null //<div>Error: {error.message}</div>;
            } else if (!isLoaded) {
              return <div><Menu links={this.state.data.links} />
              {/*<Navigation user={data.user} csrf={csrf}/>*/}
              <Dashboard links={this.state.data.links} user={this.state.data.user} widgets={widg} isLoaded={isLoaded}/>
              </div>
            } else {
              return (
                <div>
                    <Menu links={data.links} />
                    <Dashboard links={data.links} user={data.user} widgets={widg} isLoaded={isLoaded}/>
                </div>
              );
            }
          }

    getData(){

        axios.get("/api/user?api_token=" + this.state.token)
          .then(result => this.setState({
            data: result.data.data,
            isLoaded: true
          }))
          .catch(error => this.setState({
            error,
            isLoaded: true
          }));
    }

    }    

if (document.getElementById('main')) {
    const el = document.getElementById('main')
    ReactDOM.render(<Main token={el.dataset.token} csrf={el.dataset.csrf}/>, el);
}
