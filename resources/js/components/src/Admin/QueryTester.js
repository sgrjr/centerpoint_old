import React from 'react';
import PropTypes from 'prop-types';
import Typography from '@material-ui/core/Typography';

function objectToArray(obj){
  let list = []

  for (let [key,val] of Object.entries(obj)){
    list.push({key: key, value: JSON.stringify(val)})
  }

  return list
}

function list(item, prop){

  if(Array.isArray(item[prop])){
    return (item[prop].map((ext)=>{
      return (<li>{JSON.stringify(ext)}</li>)
    }))
  }else if(typeof item[prop] === "object"){
    return (objectToArray(item[prop]).map((item)=>{
      return (<li>{item.key}: {JSON.stringify(item.value)}</li>)
    }))
  }else{
    return (<li>{JSON.stringify(item[prop])}</li>)
  }
}

function Errors(props) {

  return (
    <ol>
    {props.items.map(function(item, i){
      return (<li key={i}>{item.message}>
        <ul>extensions:
        {list(item, "extensions")}
        </ul>
        <ul>locations:
        {list(item, "locations")}
        </ul>
        </li>)
    })}
    </ol>
  )
}

function Viewer(props) {

  return (
    <ol style={{overflow:"scroll"}}>
    {objectToArray(props.viewer).map(function(item, i){
      return (<li key={i}>{item.key} : {item.value}</li>)
    })}
    </ol>
  )
}

const DATA_TYPES = {
  EMPTY: "EMPTY",
  ERROR: "ERROR",
  UNKOWN: "UNKNOWN",
  VIEWER: "VIEWER"
}

export default function Card(props) {

  const type = (data) => {

    if(data === null || data === undefined){
      return DATA_TYPES.EMPTY;
    }else if(data.hasOwnProperty("message") && data.hasOwnProperty("extensions") && data.hasOwnProperty("locations") ){
      return DATA_TYPES.ERROR;
    }else if(data.hasOwnProperty("browse") && data.hasOwnProperty("search")){
      return DATA_TYPES.VIEWER;
    }else{
      return DATA_TYPES.UNKNOWN;
    }
  }

  const get = (data) => {

    let testIt = null
    if(data !== null && data !== undefined && Array.isArray(data)){
      testIt = data[0]
    }else{
      testIt = data
    }
 
    switch(type(testIt)){
      case DATA_TYPES.UNKNOWN:
        return <p style={{overflow:"hidden"}}>{JSON.stringify(data)}</p>
      case DATA_TYPES.ERROR:
        return <Errors items={data}/>
      case DATA_TYPES.VIEWER:
        return <Viewer viewer={data}/>
      case DATA_TYPES.EMPTY:
        return <h1>null</h1>
      default:
        return <Viewer viewer={data}/>
    }
  }

  return (
    <React.Fragment>
      <Typography component="h2" variant="h6" gutterBottom style={{backgroundColor:"#0090b8", paddingLeft:"10px", color:"white"}}>
        {props.title}
      </Typography>
      {get(props.data)}
      
    </React.Fragment>
  );
}

Card.propTypes = {
  children: PropTypes.node,
};
