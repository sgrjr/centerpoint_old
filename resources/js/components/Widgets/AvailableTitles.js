import React, { Component } from 'react';

export default class AvailableTitles extends Component {

    render() {

      return (<div className={this.props.cName}>

				    @foreach($titles AS $title)
				        <div  style={{color:"$title->so->color", float:"left", margin:"10px", width:"160px", height:"400px"}}>
				        <a href= "/isbn/$title->book->isbn">
	
				        </a>
				        <ul style={{listStyle:"none", width:"100%", padding:"0"}}>
				          <li style={{whiteSpace:"nowrap", overflow:"hidden", textOverflow:"ellipsis"}}>$title->book->TITLE</li>
				          <li style={{whiteSpace:"nowrap", overflow:"hidden", textOverflow:"ellipsis"}}>$title->book->SOPLAN</li>
				          <li>$title->so->SALEPRICE</li>
				          </ul>
				      @if(Auth::check())
				        @include('order_form',["isbn"=>$title->book->isbn, "index"=>$title->book->index])
				      @endif
				          
				      </div>

				    @endforeach

				</div>
      );
            }

 }