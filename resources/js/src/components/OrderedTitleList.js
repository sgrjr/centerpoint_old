import React from 'react';
import TitleSummary from '../ProductStore/TitleSummary'
import { Grid } from '@material-ui/core';

export default function OrderedTitleList(props) {

	const {heading, minify, titles, createCart, authenticated, pathname, viewer, max} = props

	const headingStyle = {
		textAlign:"center",
		width:"100%"
	}

	const counterStyle = {
		fontSize:"1.2rem",
		borderRadius: "50%",
		width: "60px",
		height: "60px",
		background: "#fff",
		border: "3px solid #105eec",
		color: "000",
		textAlign: "center",
		margin:"auto",
		lineHeight:"50px"
	}

	let ctr = 0

  return (<>
  	<h1 style={headingStyle}>{heading}</h1>

  	<Grid container justifyContent="center">
	  	{props.titles.map(title=>{
	  		ctr++
	        return (<Grid item sm={12} md={8} className={"box"} key={title.ISBN}>
	        	<h2 style={counterStyle}>#{ctr}</h2><TitleSummary minify={false} {...title} createCart={createCart} authenticated={authenticated} url={pathname} viewer={viewer}/>
	        	</Grid>)
	     })}
  	</Grid>
  	</>)
  ;
}