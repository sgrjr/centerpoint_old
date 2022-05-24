import React, { Component } from 'react';

export default class Loading extends Component {

    render() {

    	if(this.props.ready){
    		return null
    	}else{
    		return <div className="spinner-border text-dark" role="status"></div>
    	}

    }

 }