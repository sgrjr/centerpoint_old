import React, { Component } from 'react';
import ReactDOM from 'react-dom';

export default function Button(props) {

    let style = {
        ...props.style
    }

    let color = props.color? props.color:"default";
    let variant = props.variant? props.variant:"contained";
    let className = color+"-"+variant

    if(props.className) className += " " + props.className

    let disabled = false
    if(props.disabled && props.disabled === true){
        disabled = true
    } 

    if(props.minimize && props.minimize == true){
        className += " " + "min"
    }

    return (
        <button id={props.id} className={className} style={style} onClick={props.onClick} disabled={disabled}>
        {props.startIcon}
        <span className="text">{props.children}</span>
        {props.endIcon}
        </button>
  
    );
 }