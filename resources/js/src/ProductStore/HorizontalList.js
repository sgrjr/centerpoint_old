import React from 'react';
import Grid from '@material-ui/core/Grid';
import ImageList from '@material-ui/core/ImageList';
import ImageListItem  from '@material-ui/core/ImageListItem';
import ImageListItemBar  from '@material-ui/core/ImageListItemBar';
import Typography from '@material-ui/core/Typography';
import IconButton from '@material-ui/core/IconButton';
import IconPicker from '../components/IconPicker'
import Button from '@material-ui/core/Button';
import BookCover from './BookCover'
//import Paper from '@material-ui/core/Paper';
import addTitleToCartQuery from '../Cart/addTitleToCartQuery'
import WithRouter from '../components/WithRouter'


function getTitleBar(props, item, index){
  let shoppingCart = <IconPicker name="shoppingCartRemove" />

  if(!props.viewer || !props.viewer.KEY || !props.viewer.vendor){
    shoppingCart = null
  }else if(props.viewer && props.viewer.pending !== true && props.selectedCart && props.viewer.KEY && item.STATUS !== "Out Of Print"){
      shoppingCart = <IconButton aria-label={`cart ${item.TITLE}`} style={{color: "inherit"}} onClick={function(){
                  props.addTitleToCart(addTitleToCartQuery({
                    REMOTEADDR: props.selectedCart,
                    ISBN: item.ISBN,
                    QTY: 1
                  }));
                }}>
                  <IconPicker name="shoppingCartAdd" />
                </IconButton>
    }
    return ( <ImageListItemBar 
              title={item.TITLE}
              subtitle={"$" + item.LISTPRICE}
              actionIcon={
                shoppingCart
              }
            /> )
}
function SingleLineGridList(props) {

    const {listTitle, items, pageInfo} = props

    let displayHorizontal = ""

    if(!props.displayHorizontal){
        displayHorizontal = " titles-list-root-scroll"
    }

    let button = null 
    let button2 = null

    if(props.url != null){
      button = <Button variant="outlined" onClick={() => props.navigate(props.url)}>view more</Button>
      button2 = <Button variant="outlined" onClick={() => props.navigate( props.url)}>view more</Button>
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

      <ImageList className={"titles-list-root" + displayHorizontal }>
        {items.map((item, index) => (
          <Grid key={index} item xs={6} sm={3} style={{height:"inherit", margin:"inherit", padding:"inherit"}}>
          <ImageListItem>
              <BookCover link={"/isbn/" + item.ISBN} image={"url(" + item.coverArt + ")"} />
              {getTitleBar(props, item, index)}
          </ImageListItem>
          </Grid> 
        ))}
        <Grid className="view-more-button" item xs={6} style={{padding:"inherit", paddingTop:0}}>
          <ImageListItem>
              {button2}
          </ImageListItem>
        </Grid>
      </ImageList>
      
    </div>
  );
  }
}

export default WithRouter(SingleLineGridList)