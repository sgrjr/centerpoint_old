import React, { Component } from 'react';
import List from '@material-ui/core/List';
import ListItem from '@material-ui/core/ListItem';
import ListItemText from '@material-ui/core/ListItemText';
import Progress from '@material-ui/core/LinearProgress';
import Typography from '@material-ui/core/Typography';
import Grid from '@material-ui/core/Grid';
import Divider from '@material-ui/core/Divider';
import { makeStyles } from '@material-ui/core/styles';
import {withTheme} from '@material-ui/core/styles';

const useStyles = makeStyles(theme => ({
  root: {
      color:"transparent",
      textShadow:"0 0 25px rgb(0,0,0)",
      border:"lightgray",
      animation: `$loading 900ms ${theme.transitions.easing.easeInOut} infinite`
  },
  links: {
    width: "100%", 
    background:"transparent",
    color: "transparent",
    textShadow:"0 0 25px rgb(0,0,0)",
    border:"lightgray",
    animation: `$loading 900ms ${theme.transitions.easing.easeInOut} infinite`
  },
  "@keyframes loading": {
  "from": {
    textShadow:"0 0 25px rgb(0,0,0)"
  },
  "to": {
    textShadow: "0 0 15px rbg(200,200,200)",
    color:"rgba(0,0,0,.01)"
  }
}

}));

const TitlePageSkeleton = (props) => {

  const classes = useStyles(props.theme);

  return (<Grid container className={"title-page " + classes.root}>

            <Grid item xs={12} md={12} >
            <Typography variant="h3">
              TITLE of the BOOK is
            </Typography>
            </Grid>
          <Grid item xs={10} md={5}>           
            
            <div> 
              <div className="MuiPaper-root book-cover book-cover-art-large MuiPaper-elevation1" style={{background: "transparent"}}>
                <span className="book-cover-effect book-cover-effect-large"></span>
              </div>
            </div>

            <Divider style={{margin:"30px"}} />

            <button className={classes.links}>
                Login to Order
            </button>
            
          </Grid>
          <Grid item xs={10} md={5} style={{marginTop:"50px"}}>
          <Typography variant="body1">
              title.SUBTITLE
            </Typography>

          <Typography variant="h5">
              LIST PRICE: title.LISTPRICE? title.LISTPRICE:circle
            </Typography>
            <Typography variant="body1">
              title.HIGHLIGHT
            </Typography>
            <List id="book-details">
              <ListItem>
                <ListItemText>
                  <Typography fontWeight={500} fontStyle="italic">Author: </Typography>
                </ListItemText>
                <ListItemText>
                  <Typography>title.AUTHOR</Typography>
                </ListItemText>
              </ListItem>
              <ListItem>
                <ListItemText>
                  <Typography fontWeight={500} fontStyle="italic">ISBN: </Typography>
                </ListItemText>
                <ListItemText>
                  <Typography>title.ISBN</Typography>
                </ListItemText>
              </ListItem>
              <ListItem>
                <ListItemText>
                  <Typography fontWeight={500} fontStyle="italic">Publisher: </Typography>
                </ListItemText>
                <ListItemText>
                  <Typography>title.INVNATURE</Typography>
                </ListItemText>
              </ListItem>
              <ListItem>
                <ListItemText>
                  <Typography fontWeight={500} fontStyle="italic">Publish Date: </Typography>
                </ListItemText>
                <ListItemText>
                  <Typography>title.PUBDATE</Typography>
                </ListItemText>
              </ListItem>
              <ListItem>
                <ListItemText>
                  <Typography fontWeight={500} fontStyle="italic">Pages: </Typography>
                </ListItemText>
                <ListItemText>
                  <Typography>title.PAGES</Typography>
                </ListItemText>
              </ListItem>
              <ListItem>
                <ListItemText>
                  <Typography fontWeight={500} fontStyle="italic">Format: </Typography>
                </ListItemText>
                <ListItemText>
                  <Typography>title.FORMAT</Typography>
                </ListItemText>
              </ListItem>
              <ListItem>
                <ListItemText>
                  <Typography fontWeight={500} fontStyle="italic">Category: </Typography>
                </ListItemText>
                <ListItemText>
                  <Typography>title.cat</Typography>
                </ListItemText>
              </ListItem>

             

              <ListItem>
                <ListItemText>
                  <Typography fontWeight={500} fontStyle="italic">Status: </Typography>
                </ListItemText>
                <ListItemText>
                  <Typography>title.STATUS</Typography>
                </ListItemText>
              </ListItem>

            </List>
          </Grid>
          
           <Grid item xs={10} style={{marginTop:"30px"}}>
              <Typography variant="h4">t.body.subject: </Typography>
            <Typography variant="body1">asdaflkajsdfasdf</Typography>
            </Grid>

            <Grid item xs={10} style={{marginTop:"30px"}}>
              <Typography variant="h4">t.body.subject: </Typography>
            <Typography variant="body1">asdaflkajsdfasdf</Typography>
            </Grid>

            <Grid item xs={10} style={{marginTop:"30px"}}>
              <Typography variant="h4">t.body.subject: </Typography>
            <Typography variant="body1">asdaflkajsdfasdf</Typography>
            </Grid>

            <Grid item xs={10} style={{marginTop:"30px"}}>
              <Typography variant="h4">t.body.subject: </Typography>
            <Typography variant="body1">asdaflkajsdfasdf</Typography>
            </Grid>

        </Grid>    )
}

export default withTheme(TitlePageSkeleton)