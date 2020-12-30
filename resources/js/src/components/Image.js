import React from 'react';

export default function Image(props) {

    const src = props.src

  return (<img 
    src={src} 
    style={props.style} 
    alt={props.alt}
    className={props.className}
    name={props.name}
    id={props.id}
    />)
  ;
}