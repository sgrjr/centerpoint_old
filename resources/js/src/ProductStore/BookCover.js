import React from 'react';
import { Link } from "react-router-dom";
import Paper from '@material-ui/core/Paper';
//import LazyLoad from 'react-lazy-load'; //https:/ / medium.com /@rossbulat/lazy-image-loading-in-react-the-full-breakdown-4026619de2df

export default function BookCover(props) {

  const {link, image, large, previouslyPurchased, isClearance} = props
  
  var largeArtStyle = ""
  var largeEffectStyle = ""
  let clearanceBadge = isClearance? "url(/img/clearance_badge.png), ":"url(/img/img), "

  var imageStyle ={
    backgroundImage: clearanceBadge + image,
    backgroundPosition: "top right, center",
    backgroundRepeat: "no-repeat, no-repeat",
    backgroundSize: "33%, cover"
  }

   if(previouslyPurchased){
      imageStyle =  {
        backgroundImage: clearanceBadge + "url('/img/PREV_PURCH.png')" + ", " + image,
        backgroundPosition: "top right, center, center",
        backgroundRepeat: "no-repeat, no-repeat, no-repeat",
        backgroundSize: "120px, contain, cover"
      }
  }

  if(large){
    largeArtStyle = " book-cover-art-large"
    largeEffectStyle = " book-cover-effect-large"
  }

  let mainStyle = {}  

  return (
      <Link to={link} style={mainStyle}>
            <Paper className={"book-cover" + largeArtStyle} style={imageStyle} alt={props.alt} square={true}>
              <span className={"book-cover-effect" + largeEffectStyle} />
              </Paper>
        </Link>
  );
}