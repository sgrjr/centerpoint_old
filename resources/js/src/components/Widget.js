import React from 'react';
import Card from './Card';
import Grid from '@material-ui/core/Grid';
import CircularProgress from '@material-ui/core/CircularProgress';

export default function Widget(props) {
  const content = (ready)=>{
    
    if(ready === "hide"){
      return null
    }else if(ready){
      return props.children
    }else{
      return <CircularProgress color={"secondary"}/>
    }
  }

  return (<Card title={props.title}>
            <Grid
              container
              direction="row"
              justifyContent="center"
              alignItems="center"
            >

              {content(props.ready)}

            </Grid>
        </Card>
  );
}
