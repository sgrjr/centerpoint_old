import React, { Component } from 'react';

export default class DashboardHeader extends Component {

    render() {

      return (<div className={this.props.cName}>
                    <div>
                      <h2 className="font-weight-bold mb-0">Dashboard</h2>
                    </div>
                    <div className="float-right">
                        <button type="button" className="btn btn-primary btn-icon-text btn-rounded">
                          <i className="ti-clipboard btn-icon-prepend"></i>Report
                        </button>
                    </div>
              </div>
      );
            }

 }