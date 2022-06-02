import React from 'react';
import { LazyLoadImage } from 'react-lazy-load-image-component';

export default function Image(props) {

    const src = props.src

  return (<LazyLoadImage
    src={src} 
    style={props.style} 
    alt={props.alt}
    className={props.className}
    name={props.name}
    id={props.id}
    height={props.height? prop.height:"100px"}
    width={props.width? prop.width:"100px"}
    delayTime={props.delay? props.delay:1000}
    effect={props.effect? props.effect:"blur"}
    />)
  ;
}