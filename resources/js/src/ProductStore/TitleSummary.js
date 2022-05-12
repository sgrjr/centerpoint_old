import React from 'react';
import { Link } from "react-router-dom";
import { Grid } from '@material-ui/core';
import AddToCart from '../Cart/AddToCart'
import BookCover from './BookCover'

export default function TitleSummary(props) {
  let addToCart = null
  let mainStyle = {}

  if(props.authenticated && props.viewer.vendor){
    addToCart =  <AddToCart title={props} url={props.url} createCart={props.createCart}/>
  }
  if(props.minify){
     return (
              <div className="minified-titles" style={mainStyle}>
                <div style={{height:"75px", overflow:"hidden"}}>
                    <BookCover link={"/isbn/" + props.ISBN} image={"url(" + props.coverArt + ")"} alt={`${props.title} cover`} isClearance={props.isClearance} />
                </div>
                <div style={{display:"flex"}}>
                  <p style={{width:"300px", paddingRight:"15%"}}><Link to={"/isbn/"+props.ISBN}>"<span dangerouslySetInnerHTML={{__html: props.title}}/>" | {props.AUTHOR} | $ {props.isClearance? props.FLATPRICE:props.LISTPRICE} | {props.CAT}</Link></p>
                  {addToCart}
                </div>
              </div>
  );
  }else{
    return (
              <Grid container className="search-results" direction="row" justifyContent="space-between" alignItems="flex-start" spacing={2} style={mainStyle}>
                <Grid item xs={3}>
                  <div>
                    <BookCover link={"/isbn/" + props.ISBN} image={"url(" + props.coverArt + ")"} alt={`${props.title} cover`} isClearance={props.isClearance} />
                  </div>  
                </Grid>
                <Grid item xs={6}>
                  <ul className="dotted-list">
                  <li><Link to={"/isbn/"+props.ISBN}><span dangerouslySetInnerHTML={{__html: props.title}}/></Link></li>
                  <li>{props.AUTHOR}</li>
                  <li>Price: $ {props.isClearance? props.FLATPRICE:props.LISTPRICE.toFixed(2)}</li>
                  {props.SOPLAN? <li>Standing Order Plan: {props.SOPLAN}</li>:""}
                  <li>ISBN-13: {props.ISBN} | {props.FORMAT} </li>
                  <li>Published: {props.PUBDATE}</li>
                  <li>Genre: {props.CAT}</li>
                  <li>Status: {props.STATUS}</li>
                  <li>Publisher: {props.PUBLISHER}</li>
                  
                  {props.purchasedCount? <li>"# sold: " + props.purchasedCount</li>:""}
                  </ul>
                </Grid>
                <Grid item xs={3}>
                  {addToCart}
                </Grid>
                </Grid>
  );
  }
  
}