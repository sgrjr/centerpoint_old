import React, { Component } from 'react';
import { connect } from 'react-redux'
import PropTypes from 'prop-types';
import { Grid, withStyles } from '@material-ui/core';
import actions from '../actions';
import { withRouter } from "react-router";
import Button from '@material-ui/core/Button';
import Progress from '@material-ui/core/LinearProgress';
import Image from '../components/Image'
import BrowseProducts from '../components/BrowseProducts'
import TitleSummary from './TitleSummary'

const useStyles = theme => ({
      paper: {
        height: 140,
        width: 100,
      },
      gridItem: {},
  });

class SearchPage extends Component{

    componentDidMount(){
      
      window.addEventListener('scroll', this.listenToScroll.bind(this))

      const { search, filter } = this.props.match.params

      const fltr = filter

      if(!search){
        //
      }else{
        let filters = {}
        filters[fltr] = search;

       // if(fltr !== "title" || fltr !== "title" || fltr !== "title" || ){
       //   filters["invnature"] = "CENTE";
       //   filters["reverseStatus"] = "Out Of Print";
       // }

        //NO TRADE TITLES, NOT OLDER THAN 5 years, NOT OUT OF PRINT
        this.props.titlesGet(this.props.searchQuery({
          page: this.props.pagination.page,
          perPage: this.props.pagination.perPage,
          filters
          }))
      }
        
    }

    componentWillReceiveProps(newProps){
      const { search, filter } = newProps.match.params
      
      const fltr = filter.toLowerCase()
      const pFltr = this.props.match.params.filter.toLowerCase()

      if(search !== this.props.match.params.search || fltr !== pFltr || newProps.pagination.perPage !== this.props.pagination.perPage){
        if(!search){
          //
        }else{
          let filters = {}
          filters[fltr] = search;
  
          if(fltr !== "title" || fltr !== "isbn" || fltr !== "isbn"){
            filters["invnature"] = "CENTE";
            filters["reverseStatus"] = "Out Of Print";
          }
  
          //NO TRADE TITLES, NOT OLDER THAN 5 years, NOT OUT OF PRINT
          this.props.titlesGet(this.props.searchQuery({
            keep: true,
            page: newProps.pagination.page,
            perPage: newProps.pagination.perPage,
            filters
            }))
        }
      }

    }

  componentWillUnmount() {
    window.removeEventListener('scroll', this.listenToScroll)
  }
    render(){

        const { classes, createCart, lists, match } = this.props;

        let viewmore = null

          if(!lists || !lists[0] || !lists[0][1]){
            return <Progress color="primary" />
          }else if(this.props.titlesProgress){
            viewmore = <Progress color="primary" />
          }else if(lists && lists[0] && lists[0][1].paginatorInfo.hasMorePages){
            viewmore = <Button size="small" variant="outlined" style={{height:"30px", margin: "auto auto"}} onClick={() => this.props.incrementPagination()}>view more</Button>
          }

        let errors = null

       if(this.props.errors){
          errors = this.props.errors.map(function(er){
            return <li>{er.message}</li>;
          })
        }

        return(
        <div style={{margin:"30px"}}>
       {errors}
        <Grid container justify = "center"  className={classes.searchMain}>

                <Grid item sm={12} md={2}>
                <a href={this.props.catalog.pdf_link} target="_BLANK" rel="noopener noreferrer">
                    <Image src={this.props.catalog.image_link} style={{"height":"209px", "width":"160px", margin:"auto", display:"block"}} alt=""/>
                  </a>
                  <BrowseProducts browse={this.props.browse} open={false}/>

                  {viewmore}

                  <p>Loaded: {lists[0][1].paginatorInfo.perPage} | Matches: {lists[0][1].paginatorInfo.total}</p>


                  </Grid>
                <Grid item sm={12} md={8} className={"box "+ classes.gridItem}>

                  {lists[0][1].data.map(title=>{
                    return <TitleSummary key={title.ISBN} {...title} createCart={createCart} authenticated={this.props.authenticated} match={match}/>
                    })}
                  {viewmore}

                  <p>Loaded: {lists[0][1].paginatorInfo.perPage} | Matches: {lists[0][1].paginatorInfo.total}</p>

                </Grid>
         </Grid>
         </div>


        )
    }

  listenToScroll(){
    const winScroll =
      document.body.scrollTop || document.documentElement.scrollTop

    const height =
      document.documentElement.scrollHeight -
      document.documentElement.clientHeight

    const scrolled = winScroll / height

    if(scrolled >= .9 && !this.props.titlesProgress && this.props.lists[0][1].paginatorInfo.hasMorePages){
      this.props.incrementPagination()
    }
  }

}    

SearchPage.propTypes = {
    loadClientPending: PropTypes.func,
    classes: PropTypes.object,
    lists: PropTypes.array,
    match: PropTypes.object,
  };

const mapStateToProps = (state)=>{
return {
    lists: state.titles.lists,
    errors: state.titles.errors,
    pagination: state.titles.pagination,
    titlesProgress: state.titles.pending,
    catalog: state.application.catalog,
    browse: state.application.browse,
    searchQuery: state.titles.searchQuery,
    authenticated: state.viewer.KEY? true:false
     }
}

const mapDispatchToProps = dispatch => {
    return {
      titlesGet: (query) => {
        dispatch(actions.titles.TITLES_GET.creator(query))
      },
      incrementPagination: () => {
        dispatch(actions.titles.TITLES_INCREMENT_PERPAGE.creator())
      },
      createCart: ()=>{
        dispatch(actions.cart.CART_CREATE.creator())
      }
    }
  }

export default withRouter(connect(mapStateToProps, mapDispatchToProps)(withStyles(useStyles)(SearchPage)))