import React from 'react';
import Card from '../components/Card'
import authorization from '../authorization'
import BookCover from '../ProductStore/BookCover'
import GetMarc from '../components/GetMarc'

export default function QuickLInks(props) {

if(props.user.vendor && props.user.vendor.isbns){
	let list = []

  return (
    <Card title={"Titles Purchased ("+props.user.vendor.isbns.length+")"}>

    <GetMarc isbns={props.user.vendor.isbns} />

    {props.user.vendor.isbns.map(function(isbn,i){
    	if(list[isbn] === undefined){
    		list[isbn] = isbn
			return <span key={i} style={{float:"left", margin:"10px"}}><BookCover link={"/isbn/" + isbn} image={"url(img/small/" + isbn + ".jpg)"} large={false}/>
      <a href={"/static/marcs/"+isbn+".mrc"}>download marc</a></span>
    	}
    })}

  </Card>
  );}else{
  	return <div/>
  }
}
