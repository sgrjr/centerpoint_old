import React, { Component } from 'react';

export default class ProfileImage extends Component {

    render() {

      return (<div className={this.props.cName}>
                <img src={"/uploads/avatar/" + this.props.data.user.key + ".png"} style={{height:"150px"}}/>

                <form action="/dashboard/update/avatar" method="post" enctype="multipart/form-data">
				    Select image to upload:
				    <input type="hidden" name="userkey" id="userkey" value={this.props.data.user.key} />
				     <input type="hidden" name="_token" value={this.props.csrf} />
				    <input type="file" name="file" id="file" />
				    <input className="btn btn-lg btn-outline-light text-primary rounded-0 border-0" type="submit" value="Save New Profile Image" name="submit" />
				</form>

              </div>
      );
            }

 }