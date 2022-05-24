import React from 'react';
import Grid from '@material-ui/core/Grid';
import GridList from '@material-ui/core/GridList';
import GridListTile from '@material-ui/core/GridListTile';
import GridListTileBar from '@material-ui/core/GridListTileBar';
import Typography from '@material-ui/core/Typography';
import IconButton from '@material-ui/core/IconButton';
import StarBorderIcon from '@material-ui/icons/StarBorder';
import Button from '@material-ui/core/Button';
import { useHistory } from "react-router-dom";
import BookCover from './BookCover'
//import Paper from '@material-ui/core/Paper';

const viewmore = function(history, url) {
    history.push(url)
}

export default function SingleLineGridList(props) {
    let history = useHistory();

    const {listTitle, items} = props
    let displayHorizontal = ""

    if(!props.displayHorizontal){
        displayHorizontal = " titles-list-root-scroll"
    }

    let button = null 
    let button2 = null

    if(props.url != null){
      button = <Button variant="outlined" onClick={() => viewmore(history, props.url)}>view more</Button>
      button2 = <Button variant="outlined" onClick={() => viewmore(history, props.url)}>view more</Button>
    }

    if(items === undefined || items === null){
      return null
    }else{


  return (
    <div className={"titles"} >
        <Grid item xs={12}>
          <Typography variant="h3" ><span dangerouslySetInnerHTML={{__html: listTitle}}/> {button}</Typography> 
        </Grid>

      <GridList className={"titles-list-root" + displayHorizontal }>
        {items.map((item, index) => (
          <Grid key={index} item xs={6} sm={3} style={{height:"inherit", margin:"inherit", padding:"inherit"}}>
          <GridListTile>
              <BookCover link={"/isbn/" + item.ISBN} image={"url(" + item.defaultImage + ")"} />
            <GridListTileBar
              title={item.TITLE}
              subtitle={"$" + item.LISTPRICE}
              actionIcon={
                <IconButton aria-label={`star ${item.TITLE}`} style={{color: "inherit"}}>
                  <StarBorderIcon style={{color: "inherit"}}/>
                </IconButton>
              }
            /> 
          </GridListTile>
          </Grid>
        ))}
        <Grid className="view-more-button" item xs={6} style={{padding:"inherit", paddingTop:0}}>
          <GridListTile>
              {button2}
          </GridListTile>
        </Grid>
      </GridList>
      
    </div>
  );
  }
}