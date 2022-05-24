import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios'

export default class Cart extends Component {

  constructor(props) {
    super(props);

    this.state = {
      error: null,
      isLoaded: false,
      data: {
        links:[],
        user: {}
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

            if (error) {
              return null //<div>Error: {error.message}</div>;
            } else if (!isLoaded) {
              return <div><Menu links={data.links} />
              {/*<Navigation user={data.user} csrf={csrf}/>*/}
              
              <Dashboard 
                links={data.links} 
                user={data.user} 
                activeSo={data.activeSo} 
                cartsCount={data.cartsCount} 
                carts={data.carts}
                processingCarts={data.processing_carts}
                processingCount={data.processing_count}
                csrf={csrf}
                />

              </div>
            } else {
              return (
                <div>
                    <Menu links={data.links} />
                    <Dashboard links={data.links} user={data.user}/>
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
