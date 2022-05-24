import React, { Component } from 'react';

export default class ToDoList extends Component {

    render() {

      return (<div className={this.props.cName}>

                <div className="row list-wrapper">
                    <ul className="d-flex flex-column-reverse todo-list todo-list-custom">
                        <li>
                          <div className="form-check form-check-flat">
                            <label className="form-check-label">
                              <input className="checkbox" type="checkbox"/>
                              Become A Travel Pro In One Easy Lesson
                            </label>
                          </div>
                          <i className="remove ti-trash"></i>
                        </li>
                        <li className="completed">
                          <div className="form-check form-check-flat">
                            <label className="form-check-label">
                              <input className="checkbox" type="checkbox" defaultChecked onChange={this.onChange}/>
                              See The Unmatched Beauty Of The Great Lakes
                            </label>
                          </div>
                          <i className="remove ti-trash"></i>
                        </li>
                        <li>
                          <div className="form-check form-check-flat">
                            <label className="form-check-label">
                              <input className="checkbox" type="checkbox"/>
                              Copper Canyon
                            </label>
                          </div>
                          <i className="remove ti-trash"></i>
                        </li>
                        <li className="completed">
                          <div className="form-check form-check-flat">
                            <label className="form-check-label">
                              <input className="checkbox" type="checkbox" defaultChecked/>
                              Top Things To See During A Holiday In Hong Kong
                            </label>
                          </div>
                          <i className="remove ti-trash"></i>
                        </li>
                        <li>
                          <div className="form-check form-check-flat">
                            <label className="form-check-label">
                              <input className="checkbox" type="checkbox"/>
                              Travelagent India
                            </label>
                          </div>
                          <i className="remove ti-trash"></i>
                        </li>
                      </ul>
                      </div>

                    <div className="row">
                    <div className="add-items d-flex mb-0 mt-4">
                      <input type="text" className="form-control todo-list-input mr-2"  placeholder="Add new task"/>
                      <button className="add btn btn-icon text-primary todo-list-add-btn bg-transparent"><i className="ti-location-arrow"></i></button>
                    </div>
                    </div>
                  </div>
      );
            }

 }