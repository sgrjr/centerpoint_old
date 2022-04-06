import React from 'react';
import { Link } from "react-router-dom";
import Paper from '@material-ui/core/Paper';
//import LazyLoad from 'react-lazy-load'; //https:/ / medium.com /@rossbulat/lazy-image-loading-in-react-the-full-breakdown-4026619de2df

export default function BookCover(props) {

  const {link, image, large, previouslyPurchased} = props
  
  var largeArtStyle = ""
  var largeEffectStyle = ""

  var imageStyle ={
    backgroundImage: image
  }

   if(previouslyPurchased){
      imageStyle =  {
        backgroundImage: "url('/img/PREV_PURCH.png')" + ", " + image,
        backgroundPosition: "center, center",
        backgroundRepeat: "no-repeat, no-repeat",
        backgroundSize: "contain, cover"
      }
  }


  if(large){
    largeArtStyle = " book-cover-art-large"
    largeEffectStyle = " book-cover-effect-large"
  }

  return (
      <Link to={link}> 
            <Paper className={"book-cover" + largeArtStyle} style={imageStyle} alt={props.alt} square={true}>
              <span className={"book-cover-effect" + largeEffectStyle} />
              </Paper>
        </Link>
  );
}