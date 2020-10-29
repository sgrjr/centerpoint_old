import React, { Component } from 'react';

export default class Purchases extends Component {

    render() {

      return (<div className={this.props.cName}>
				  <h2>Purchases</h2>
				  <canvas id="order-chart" className="w-100"></canvas>
				</div>
      );
            }

 }