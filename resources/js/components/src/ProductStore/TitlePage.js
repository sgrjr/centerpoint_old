import React, { Component } from 'react';
import { connect } from 'react-redux'
import PropTypes from 'prop-types';
import actions from '../actions';
import { withRouter } from "react-router";
import List from '@material-ui/core/List';
import ListItem from '@material-ui/core/ListItem';
import ListItemText from '@material-ui/core/ListItemText';
import Progress from '@material-ui/core/LinearProgress';
import SubtleProgress from '../components/SubtleProgress';
import Typography from '@material-ui/core/Typography';
import Grid from '@material-ui/core/Grid';
import Divider from '@material-ui/core/Divider';
import BookCover from './BookCover'
import HorizontalList from './HorizontalList'
import AddToCart from '../Cart/AddToCart'

function ListItemLink(props) {
  return <ListItem component="a" {...props} />;
}

class TitlePage extends Component{

    componentDidMount(){
      const { isbn } = this.props.match.params

       if(this.props.title && isbn !== this.props.title.ISBN ){
          this.props.titleGet(this.props.minTitleQuery({
            "page":1,
            "perPage":10,
            "isbn": isbn
          }))
        }
      }

    componentWillReceiveProps(newProps){
      const { isbn } = newProps.match.params

      const isFirstRender = isbn !== this.props.match.params.isbn
             
      if(isFirstRender){
        this.props.titleGet(this.props.minTitleQuery({
          "page":1,
          "perPage":10,
          "isbn": isbn
        }))
      }else if(newProps.authenticated && newProps.getUserData && !newProps.titlepending){
        this.props.titleGet(this.props.titleQuery({
          "page":1,
          "perPage":10,
          "isbn": isbn
        }))
      }

      }

    render(){
      const {authenticated, createCart} = this.props;
      let loading = null

      if(this.props.title){
      const title = this.props.title
      
        if(this.props.pending){
          loading = <Grid container className={"pending"}><Grid item xs={12}><Progress color="primary"/></Grid></Grid>
        }

      const copy = ()=>{

        if(title.text !== undefined){
          return title.text.map(function(t,i){
            return (<Grid item xs={10} key={i} style={{marginTop:"30px"}}>
          <Typography variant="h4">{t.body.subject}: </Typography>
            <Typography variant="body1"  dangerouslySetInnerHTML={{ __html: t.body.body }} ></Typography>
            </Grid>)
          })
        }else{
          return null
        }
      }

      let requireAuth = {}

      if(!authenticated){
        requireAuth.display = "none";
      }

      let authorTitle = "More By ";
      
      authorTitle = title.AFIRST? authorTitle + " " + title.AFIRST:authorTitle 
      authorTitle = title.ALAST? authorTitle + " " + title.ALAST:authorTitle 
      authorTitle = title.SUFFIX? authorTitle + " " + title.SUFFIX:authorTitle 
      let addToCart = <AddToCart title={title} url={this.props.match.url} createCart={createCart}/>

      const circle = <SubtleProgress />

      return (
        <Grid container className="title-page">
            <Grid item xs={12} md={12} >
              {loading}
            <Typography variant="h3">
              {title.TITLE}
            </Typography>
            </Grid>
          <Grid item xs={10} md={5}>           
            <BookCover link={""} image={"url(" + title.defaultImage + ")"} large={true} />
            <Divider style={{margin:"30px"}} />

            {addToCart}
            
          </Grid>
          <Grid item xs={10} md={5} style={{marginTop:"50px"}}>
          <Typography variant="body1">
              {title.SUBTITLE}
            </Typography>
          <Typography variant="h4" color="secondary" style={requireAuth}>
            {title.user? "YOUR PRICE: "+title.user.price : ""}
            </Typography>
          <Typography variant="h5">
              LIST PRICE: {title.LISTPRICE? title.LISTPRICE:circle}
            </Typography>
            <Typography variant="body1">
              {title.HIGHLIGHT}
            </Typography>
            <List id="book-details">
              <ListItem style={requireAuth}>
                <ListItemText>
                  <Typography fontWeight={500} fontStyle="italic">Discount: </Typography>
                </ListItemText>
                <ListItemText>
                  <Typography>{title.user? (100*title.user.discount) + "%":circle}</Typography>
                </ListItemText>
              </ListItem>
              <ListItem style={requireAuth}>
                <ListItemText>
                  <Typography fontWeight={500} fontStyle="italic">Previously Purchased: </Typography>
                </ListItemText>
                <ListItemText>
                  <Typography>{title.user? (title.user.purchased? "yes":"no"):circle}</Typography>
                </ListItemText>
              </ListItem>
              <ListItem style={requireAuth}>
                <ListItemText>
                  <Typography fontWeight={500} fontStyle="italic">On Standing Order: </Typography>
                </ListItemText>
                <ListItemText>
                  <Typography>{title.user? (title.user.onstandingorder? "yes":"no"):circle}</Typography>
                </ListItemText>
              </ListItem>

              <ListItem>
                <ListItemText>
                  <Typography fontWeight={500} fontStyle="italic">Author: </Typography>
                </ListItemText>
                <ListItemText>
                  <Typography>{title.AUTHOR}</Typography>
                </ListItemText>
              </ListItem>
              <ListItem>
                <ListItemText>
                  <Typography fontWeight={500} fontStyle="italic">ISBN: </Typography>
                </ListItemText>
                <ListItemText>
                  <Typography>{title.ISBN}</Typography>
                </ListItemText>
              </ListItem>
              <ListItem>
                <ListItemText>
                  <Typography fontWeight={500} fontStyle="italic">Publisher: </Typography>
                </ListItemText>
                <ListItemText>
                  <Typography>{title.INVNATURE}</Typography>
                </ListItemText>
              </ListItem>
              <ListItem>
                <ListItemText>
                  <Typography fontWeight={500} fontStyle="italic">Publish Date: </Typography>
                </ListItemText>
                <ListItemText>
                  <Typography>{title.PUBDATE}</Typography>
                </ListItemText>
              </ListItem>
              <ListItem>
                <ListItemText>
                  <Typography fontWeight={500} fontStyle="italic">Pages: </Typography>
                </ListItemText>
                <ListItemText>
                  <Typography>{title.PAGES}</Typography>
                </ListItemText>
              </ListItem>
              <ListItem>
                <ListItemText>
                  <Typography fontWeight={500} fontStyle="italic">Format: </Typography>
                </ListItemText>
                <ListItemText>
                  <Typography>{title.FORMAT}</Typography>
                </ListItemText>
              </ListItem>
              <ListItem>
                <ListItemText>
                  <Typography fontWeight={500} fontStyle="italic">Category: </Typography>
                </ListItemText>
                <ListItemText>
                  <Typography><span dangerouslySetInnerHTML={{__html: title.CAT}}/></Typography>
                </ListItemText>
              </ListItem>

              {()=>{
                if(title.MARC === "MARC"){
                return (
                  <ListItem>
                    <ListItemText>
                      <Typography fontWeight={500} fontStyle="italic">MARC: </Typography>
                    </ListItemText>
                    <ListItemLink href={"http://www.dgiinc.com/centerpoint/"+title.ISBN+".txt"}>view </ListItemLink>
                    <ListItemLink href={"http://www.dgiinc.com/centerpoint/"+title.ISBN+".mrc"}> | download</ListItemLink>
                  </ListItem>)
                }
              }}

              <ListItem>
                <ListItemText>
                  <Typography fontWeight={500} fontStyle="italic">Status: </Typography>
                </ListItemText>
                <ListItemText>
                  <Typography>{title.STATUS}</Typography>
                </ListItemText>
              </ListItem>

            </List>
          </Grid>
          
            {copy()}
            <Grid item xs={12} sm={10}>
              <HorizontalList items={title.sameCAT} listTitle={"More " + title.CAT} url={"/search/"+title.CAT+"/CAT"} displayHorizontal={true} background={"#2e2e2e"} />
            </Grid>
             <Grid item xs={12} sm={10}>
              <HorizontalList items={title.sameAUTHOR} listTitle={authorTitle} url={"/search/"+title.AUTHORKEY+"/AUTHORKEY"} displayHorizontal={true}  background={"#2e2e2e"} />
            </Grid>
        </Grid>      
      )
      }else{
        return  <Grid container className={"pending"}><Grid item xs={12}><Progress color="primary"/></Grid></Grid>
      }
  
    }
        
} 

TitlePage.propTypes = {
    match: PropTypes.object
  };

const mapStateToProps = (state)=>{
return {
    title: state.titles.title,
    queried: state.titles.queried,
    errors: state.titles.errors,
    pending: state.titles.titlepending,
    getUserData: state.titles.titleGetUserData,
    authenticated: state.viewer.authenticated,
    viewerPending: state.viewer.pending,
    titleQuery: state.titles.titleQuery,
    minTitleQuery: state.titles.minTitleQuery
     }
}

const mapDispatchToProps = dispatch => {
    return {
      titleGet: (query) => {
        dispatch(actions.titles.TITLE_GET.creator(query))
      },
      createCart: ()=>{
        dispatch(actions.cart.CART_CREATE.creator())
      }
    }
  }

export default withRouter(connect(mapStateToProps, mapDispatchToProps)(TitlePage))