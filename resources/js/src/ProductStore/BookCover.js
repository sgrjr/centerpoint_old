import React from 'react';
import { Link } from "react-router-dom";
import Paper from '@material-ui/core/Paper';
import LazyLoad from 'react-lazy-load'; //https:/ / medium.com /@rossbulat/lazy-image-loading-in-react-the-full-breakdown-4026619de2df

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
          <LazyLoad debounce={false} offsetVertical={500}>
            <Paper className={"book-cover" + largeArtStyle} style={imageStyle} alt={props.alt} square={true}>
              <span className={"book-cover-effect" + largeEffectStyle} />
              </Paper>
          </LazyLoad>
        </Link>
  );
}