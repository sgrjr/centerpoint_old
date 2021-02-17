import React from 'react';
import Grid from '@material-ui/core/Grid';
import GridList from '@material-ui/core/GridList';
import GridListTile from '@material-ui/core/GridListTile';
import GridListTileBar from '@material-ui/core/GridListTileBar';
import Typography from '@material-ui/core/Typography';
import IconButton from '@material-ui/core/IconButton';
import AddShoppingCartIcon from '@material-ui/icons/AddShoppingCart';
import Button from '@material-ui/core/Button';
import { useHistory } from "react-router-dom";
import BookCover from './BookCover'
//import Paper from '@material-ui/core/Paper';
import addTitleToCartQuery from '../Cart/addTitleToCartQuery'

const viewmore = function(history, url) {
    history.push(url)
}

function getTitleBar(props, item, index){
  let shoppingCart = null
  
  if(props.authorizedUser){
      shoppingCart = <IconButton aria-label={`cart ${item.TITLE}`} style={{color: "inherit"}} onClick={function(){
                  props.addTitleToCart(addTitleToCartQuery({
                    REMOTEADDR: props.selectedCart,
                    ISBN: item.ISBN,
                    QTY: 1
                  }));
                }}>
                  <AddShoppingCartIcon style={{color: "inherit"}}/>
                </IconButton>
    }
    return ( <GridListTileBar
              title={item.TITLE}
              subtitle={"$" + item.LISTPRICE}
              actionIcon={
                shoppingCart
              }
            /> )
}
export default function SingleLineGridList(props) {
    let history = useHistory();

    const {listTitle, items, pageInfo} = props

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
      return <div/>
    }else{

      let titleSize = "h3"

      if(props.titleSize){
        titleSize = props.titleSize
      }


  return (
    <div className={"titles"} >
        <Grid item xs={12} style={{padding:"15px"}}>
          <Typography variant={props.titleSize} ><span dangerouslySetInnerHTML={{__html: listTitle}}/> {button}</Typography> 
        </Grid>

      <GridList className={"titles-list-root" + displayHorizontal }>
        {items.map((item, index) => (
          <Grid key={index} item xs={6} sm={3} style={{height:"inherit", margin:"inherit", padding:"inherit"}}>
          <GridListTile>
              <BookCover link={"/isbn/" + item.ISBN} image={"url(" + item.coverArt + ")"} />
              {getTitleBar(props, item, index)}
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