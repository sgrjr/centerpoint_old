import React from 'react';
import Card from '../components/Card'

import BookCover from '../ProductStore/BookCover'

export default function QuickLInks(props) {

if(props.user.vendor && props.user.vendor.isbns){
  return (
    <Card title={"Titles Purchased ("+props.user.vendor.isbns.length+")"}>
    
    {props.user.vendor.isbns.map(function(isbn,i){
    	return <span style={{float:"left", margin:"10px"}}><BookCover link={"/isbn/" + isbn} image={"url(img/small/" + isbn + ".jpg)"} large={false}/></span>
    })}

  </Card>
  );}else{
  	return <div/>
  }
}
