import React, { Component } from 'react';
import { connect } from 'react-redux'
import PropTypes from 'prop-types';
import actions from '../actions';
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
import TitlePageSkeleton from './TitlePageSkeleton'
import GetMarc from '../components/GetMarc'
import {useParams, useLocation} from 'react-router-dom'

function ListItemLink(props) {
  return <ListItem component="a" {...props} />;
}

class TitlePage extends Component{

    componentDidMount(){

       const { isbn } = this.props.params

      if(!this.props.title || this.props.title.ISBN !== isbn){
          this.props.titleGet(this.props.minTitleQuery({
            "page":1,
            "perPage":10,
            "isbn": isbn
          }))
      }
      }

    componentDidUpdate(prevProps){
      const { isbn } = this.props.params

      const isFirstRender = isbn !== prevProps.params.isbn
             
      if(isFirstRender){
        this.props.titleGet(this.props.minTitleQuery({
          "page":1,
          "perPage":10,
          "isbn": isbn
        }))
      }else if(this.props.viewer.KEY && this.props.getUserData && !this.props.titlepending){
        this.props.titleGet(this.props.titleQuery({
          "page":1,
          "perPage":10,
          "isbn": isbn
        }))
      }

      }

    render(){

       if(this.props.pending){
          return (<Grid container className="title-page"><TitlePageSkeleton/><Grid container className={"pending"}><Grid item xs={12}><Progress color="primary"/></Grid></Grid></Grid>)
       }else if(this.props.title === null || this.props.title === undefined){
          return <p style={{textAlign:"center"}}>Sorry. We cannot find that title.</p>
       }

      const {viewer, createCart} = this.props;
      let loading = null

      if(this.props.title){
      const title = this.props.title
      
        if(this.props.pending){
          loading = <Grid container className={"pending"}><Grid item xs={12}><Progress color="primary"/></Grid></Grid>
        }

      const copy = ()=>{

        if(title.text !== undefined && title.text !== null){
          return title.text.map(function(t,i){
            return (<Grid item xs={10} key={i} style={{marginTop:"30px"}}>
          <Typography variant="h4">{t.body.subject}: </Typography>
            <Typography variant="body1"  dangerouslySetInnerHTML={{ __html: t.body.body }} ></Typography>
            </Grid>)
          })
        }else{
          return <div/>
        }
      }

      let requireAuth = {}

      let firstDivider = <Divider style={{margin:"30px"}} />

      if( viewer === undefined || viewer.KEY === undefined){
        requireAuth.display = "none";
      }

      if( viewer === undefined || viewer.KEY === undefined || title.STATUS === "Out Of Print"){
        requireAuth.display = "none";
        firstDivider = null
      }

      let authorTitle = title.AUTHOR + " Titles";
      
      const circle = <SubtleProgress />

      return (
        <Grid container className="title-page">
            <Grid item xs={12} md={12} >
              {loading}
            <Typography variant="h3" dangerouslySetInnerHTML={{__html: title.TITLE}}>
          
            </Typography>
            </Grid>
          <Grid item xs={10} md={5}>           
            <BookCover link={""} image={"url(" + title.coverArt + ")"} large={true} />
            {firstDivider}

            <AddToCart title={title} url={this.props.location.pathname} createCart={createCart}/>
            <GetMarc isbns={[title.ISBN]} />
          </Grid>
          <Grid item xs={10} md={5} style={{marginTop:"50px"}}>
          <Typography variant="body1" dangerouslySetInnerHTML={{__html: title.SUBTITLE }}></Typography>
          <Typography variant="h4" color="secondary" style={requireAuth}>
            {title && title.user? "YOUR PRICE: "+title.user.price : ""}
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
                  <Typography component={'span'}>{title && title.user? (100*title.user.discount) + "%":circle}</Typography>
                </ListItemText>
              </ListItem>
              <ListItem style={requireAuth}>
                <ListItemText>
                  <Typography fontWeight={500} fontStyle="italic">Previously Purchased: </Typography>
                </ListItemText>
                <ListItemText>
                  <Typography component={'span'}>{title && title.user? (title.user.purchased? "yes":"no"):circle}</Typography>
                </ListItemText>
              </ListItem>
              <ListItem style={requireAuth}>
                <ListItemText>
                  <Typography fontWeight={500} fontStyle="italic">On Standing Order: </Typography>
                </ListItemText>
                <ListItemText>
                  <Typography component={'span'}>{title && title.user? (title.user.onstandingorder? "yes":"no"):circle}</Typography>
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
              <HorizontalList 
                items={title.byCategory.data} 
                listTitle={"More " + title.CAT} 
                url={"/search/"+title.CAT+"/category"} 
                titleSize={"h4"} displayHorizontal={true} 
                background={"#2e2e2e"}
                viewer={viewer} />
            </Grid>
             <Grid item xs={12} sm={10}>
              <HorizontalList items={title.byAuthor.data} listTitle={authorTitle} url={"/search/"+title.AUTHORKEY+"/author"} titleSize={"h4"}  displayHorizontal={true}  background={"#2e2e2e"} viewer={this.props.viewer}/>
            </Grid>
        </Grid>      
      )
      }else{
        return  <Grid container className={"pending"}><Grid item xs={12}><Progress color="primary"/></Grid></Grid>
      }
  
    }
        
} 

TitlePage.propTypes = {
    location: PropTypes.object
  };

const mapStateToProps = (state)=>{
return {
    title: state.titles.title,
    queried: state.titles.queried,
    errors: state.titles.errors,
    pending: state.titles.titlepending,
    getUserData: state.titles.titleGetUserData,
    viewer: state.viewer,
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

const TitlePageWithParams = (props)=>{
  return <TitlePage {...props} params={useParams()} location={useLocation()}/>
}

export default connect(mapStateToProps, mapDispatchToProps)(TitlePageWithParams)