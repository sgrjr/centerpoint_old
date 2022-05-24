import React from 'react';
import { Link } from "react-router-dom";
import Paper from '@material-ui/core/Paper';

export default function BookCover(props) {

  const {link, image, large} = props
  
  var largeArtStyle = ""
  var largeEffectStyle = ""

  var imageStyle ={
    backgroundImage: image
  }

  if(large){
    largeArtStyle = " book-cover-art-large"
    largeEffectStyle = " book-cover-effect-large"
  }

  return (
      <Link to={link} >
        <Paper className={"book-cover" + largeArtStyle} style={imageStyle} alt={props.alt} square={true}>
              <span className={"book-cover-effect" + largeEffectStyle} />
        </Paper>
        </Link>
  );
}