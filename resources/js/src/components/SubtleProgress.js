import React from 'react';
import CircularProgress from '@material-ui/core/CircularProgress';

class SubtleProgress extends React.Component {

  render(){

    return <CircularProgress className={"subtle"} color={"inherit"} size={20}/>

  }
}


export default SubtleProgress