import React, { Component } from 'react';
import { connect } from 'react-redux'
import PropTypes from 'prop-types';
import { Grid, withStyles } from '@material-ui/core';
import actions from '../actions';
import Button from '@material-ui/core/Button';
import Progress from '@material-ui/core/LinearProgress';
import Image from '../components/Image'
import BrowseProducts from '../components/BrowseProducts'
import TitleSummary from './TitleSummary'
import SearchSuggestions from './SearchSuggestions'
import WithRouter from '../components/WithRouter'
import OrderedTitleList from '../components/OrderedTitleList'
import Time from '../helpers/Time'

import styles from '../styles'

const useStyles = theme => ({
      paper: {
        height: 140,
        width: 100,
      },
      gridItem: {},
  });

class SearchPage extends Component{

    constructor(props){
      super(props);
      const savedOpts = JSON.parse(localStorage.getItem("centerpoint_large_print_user_options"))

      this.state = {
        options:savedOpts? savedOpts:{minify:false}
      }
    }

    componentDidMount(){

      window.addEventListener('scroll', this.listenToScroll.bind(this))

      let { search, filter } = this.props.params

      if(!search){
        search = '';
        filter = 'isbn';
      }

        let filters = {}
        filters[filter] = search;

       // if(fltr !== "title" || fltr !== "title" || fltr !== "title" || ){
       //   filters["invnature"] = "CENTE";
       //   filters["reverseStatus"] = "Out Of Print";
       // }

        //NO TRADE TITLES, NOT OLDER THAN 5 years, NOT OUT OF PRINT
        let page = this.props.pagination.page? this.props.pagination.page:1
        let first = this.props.pagination.perPage

        if(filter === "list"){

          if(search === 'top-25-titles'){
            page = 1
            first = 25
          }

          this.props.titlesGet(this.props.listQuery({
            page: page,
            first: first,
            name: search
          }))
        }else{
          this.props.titlesGet(this.props.searchQuery({
            page: this.props.pagination.page,
            first: this.props.pagination.perPage,
            filters
          }))
        }

        
    }

    componentDidUpdate(newProps){
      let { search, filter } = newProps.params
      
      if(!search){
        filter = 'isbn';
        search = '';
      }else{
        filter = filter.toLowerCase()
      }

      let fltr = this.props.params.filter

      if(!fltr){
        fltr = 'isbns'
      }else{
        fltr = fltr.toLowerCase();
      }

        if(search !== this.props.params.search || fltr !== filter || newProps.pagination.perPage !== this.props.pagination.perPage){
          if(!search){
            //
          }else{
            let filters = {}
            filters[this.props.params.filter] = this.props.params.search;

            //if(fltr !== "title" || fltr !== "isbn" || fltr !== "isbn"){
            //  filters["invnature"] = "CENTE";
            //  filters["reverseStatus"] = "Out Of Print";
            //}

            //NO TRADE TITLES, NOT OLDER THAN 5 years, NOT OUT OF PRINT

        if(this.props.params.filter === "list"){
          let page = this.props.pagination.page? this.props.pagination.page:1
          let first = this.props.pagination.perPage

          if(search === 'top-25-titles'){
            page = 1
            first = 25
          }

            this.props.titlesGet(this.props.listQuery({
              keep:true,
              page: page,
              first: first,
              name: this.props.params.search
            }))
        }else{
            this.props.titlesGet(this.props.searchQuery({
              keep: true,
              page: newProps.pagination.page,
              first: newProps.pagination.perPage,
              filters
              }))
          }
          }
        }


    }

  componentWillUnmount() {
    window.removeEventListener('scroll', this.listenToScroll)
  }
    render(){

        const { 
          asses, createCart, lists, params, viewer } = this.props;
        const {pathname} = this.props.location
        let viewmore = null

        let searchSuggestions = null

          if(!lists || !lists[0] || !lists[0][1]){
            return <Progress color="primary" />
          }else if(this.props.titlesProgress){
            viewmore = <Progress color="primary" />
          }else if(lists && lists[0] && lists[0][1].paginatorInfo !== null && lists[0][1].paginatorInfo.hasMorePages){
            viewmore = <button className="outlined" onClick={() => this.props.incrementPagination()}>view more</button>
          }

        let errors = null

       if(this.props.errors){
          errors = this.props.errors.map(function(er,k){
            return <li key={k}>{er.message}</li>;
          })
        }

          if(lists.length < 1 || lists[0][1].paginatorInfo === null || lists[0][1].paginatorInfo.total < 1 || this.props.params.search === ""){
            let itemData = lists.length > 1 && lists[1].length > 1? lists[1][1].data:[]
            searchSuggestions = <div><h2>Nothing matched your searched. Try a suggestion below.</h2><SearchSuggestions itemData={itemData}/></div>
          }


        const toggleMinMaxView = (e)=>{
          const newState = {...this.state}
          newState.options.minify = !this.state.options.minify
          this.setState(newState)
          localStorage.setItem("centerpoint_large_print_user_options", JSON.stringify(newState.options))
        }

        if(this.props.params.search === 'top-25-titles'){
          return (<>
            {this.props.navigation}
            <OrderedTitleList titles={lists[0][1].data && lists[0][1].data} heading={"Top 25 Titles for " + Time.currentMonthName} minify={this.state.options.minify} createCart={createCart} authenticated={this.props.authenticated} url={pathname} viewer={viewer}/>
          </>)
        }

        return(
        <>
          {this.props.navigation}

          <div style={{margin:"30px"}} className={"minify-"+this.state.options.minify}>
         {errors}
          <Grid container justifyContent="center">

                  <Grid item sm={12} md={8} className={"box"}>

                    <div>
                      Loaded: {lists[0][1].paginatorInfo === null || lists[0][1].paginatorInfo.count === 0? 0:lists[0][1].paginatorInfo.count} of {lists[0][1].paginatorInfo !== null && lists[0][1].paginatorInfo.total} | 
                      {viewmore} | 
                      <button className={styles.outlined} onClick={(e)=>{toggleMinMaxView(e);}}>{this.state.options.minify? "expand":"collapse"}</button>
                    </div>
                    
                    <hr/>

                    {lists[0][1].data && lists[0][1].data.map(title=>{
                          return <TitleSummary minify={this.state.options.minify} key={title.ISBN} {...title} createCart={createCart} authenticated={this.props.authenticated} url={pathname} viewer={viewer}/>
                      })}
                    
                    {searchSuggestions}

                    {viewmore}

                    <p>Loaded: {lists[0][1].paginatorInfo === null || lists[0][1].paginatorInfo.count === 0? 0:lists[0][1].paginatorInfo.count} of {lists[0][1].paginatorInfo !== null && lists[0][1].paginatorInfo.total}</p>

                  </Grid>
           </Grid>
           </div>
         </>

        )
    }

  listenToScroll(){
    if(this.props.params.search === 'top-25-titles'){return true}

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
    lists: PropTypes.array,
    params: PropTypes.object,
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
    listQuery: state.titles.listQuery,
    authenticated: state.viewer && !state.viewer.pending && state.viewer.KEY? true:false,
    viewer: state.viewer
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

export default connect(
  mapStateToProps, mapDispatchToProps
  )
(withStyles(useStyles)(WithRouter(SearchPage)))