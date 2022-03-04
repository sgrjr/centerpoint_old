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
        this.props.titlesGet(this.props.searchQuery({
          page: this.props.pagination.page,
          perPage: this.props.pagination.perPage,
          filters
          }))
        
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

        const { classes, createCart, lists, params, viewer } = this.props;
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
          errors = this.props.errors.map(function(er){
            return <li>{er.message}</li>;
          })
        }

          if(lists[0][1].paginatorInfo === null || lists[0][1].paginatorInfo.total < 1 || this.props.params.search === ""){
            searchSuggestions = <div><h2>Nothing matched your searched. Try a suggestion below.</h2><SearchSuggestions itemData={lists[1][1].data}/></div>
          }


        const toggleMinMaxView = (e)=>{
          const newState = {...this.state}
          newState.options.minify = !this.state.options.minify
          this.setState(newState)
          localStorage.setItem("centerpoint_large_print_user_options", JSON.stringify(newState.options))
        }

        return(
        <div style={{margin:"30px"}} className={"minify-"+this.state.options.minify}>
       {errors}
        <Grid container justifyContent="center"  className={classes.searchMain}>

                <Grid item sm={12} md={8} className={"box "+ classes.gridItem}>

                  <div>
                    Loaded: {lists[0][1].paginatorInfo === null || lists[0][1].paginatorInfo.total === 0? 0:lists[0][1].paginatorInfo.perPage} | 
                    Matches: {lists[0][1].paginatorInfo !== null && lists[0][1].paginatorInfo.total} | 
                    {viewmore} | 
                    <button className={styles.outlined} onClick={(e)=>{toggleMinMaxView(e);}}>{this.state.options.minify? "expand":"collapse"}</button>
                  </div>
                  
                  <hr/>

                  {lists[0][1].data && lists[0][1].data.map(title=>{
                        return <TitleSummary minify={this.state.options.minify} key={title.ISBN} {...title} createCart={createCart} authenticated={this.props.authenticated} url={pathname} viewer={viewer}/>
                    })}
                  
                  {searchSuggestions}

                  {viewmore}

                  <p>Loaded: {lists[0][1].paginatorInfo  === null || lists[0][1].paginatorInfo.total === 0? 0:lists[0][1].paginatorInfo.perPage} | Matches: {lists[0][1].paginatorInfo !== null? lists[0][1].paginatorInfo.total:0}</p>

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

export default connect(mapStateToProps, mapDispatchToProps)(withStyles(useStyles)(WithRouter(SearchPage)))