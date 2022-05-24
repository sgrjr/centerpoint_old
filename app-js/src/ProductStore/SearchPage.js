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
import searchQuery from './searchQuery'

const useStyles = theme => ({
      paper: {
        height: 140,
        width: 100,
      },
      gridItem: {},
  });

class SearchPage extends Component{

    componentDidMount(){
      const { search, filter } = this.props.match.params
      console.log('here')
      if(!search){
        //
      }else{
        let filters = {}
        filters[filter] = search;

        if(filter !== "TITLE" || filter !== "ISBN" || filter !== "INVNATURE"){
          filters["INVNATURE"] = "CENTE";
          filters["STATUS"] = "!=_Out Of Print";
        }

        //NO TRADE TITLES, NOT OLDER THAN 5 years, NOT OUT OF PRINT
        this.props.titlesGet(searchQuery({
          page: this.props.pagination.page,
          perPage: this.props.pagination.perPage,
          filters
          }))
      }
        
    }

    componentWillReceiveProps(newProps){
      const { search, filter } = newProps.match.params
      

      if(search !== this.props.match.params.search || filter !== this.props.match.params.filter  || newProps.pagination.perPage !== this.props.pagination.perPage){
        if(!search){
          //
        }else{
          let filters = {}
          filters[filter] = search;
  
          if(filter !== "TITLE" || filter !== "ISBN" || filter !== "INVNATURE"){
            filters["INVNATURE"] = "CENTE";
            filters["STATUS"] = "!=_Out Of Print";
          }
  
          //NO TRADE TITLES, NOT OLDER THAN 5 years, NOT OUT OF PRINT
          this.props.titlesGet(searchQuery({
            keep: true,
            page: newProps.pagination.page,
            perPage: newProps.pagination.perPage,
            filters
            }))
        }
      }

    }

    render(){

        const { classes, createCart, lists, match } = this.props;
        
        if(!lists || !lists[0]){
          return <Progress color="primary" />;
        }else if(lists !== false && lists !== null && lists[0][1] === null){
          return <div>(empty)</div>
        }

        let viewmore = <Progress color="primary" /> 

          if(this.props.titlesProgress){
            viewmore = <Progress color="primary" />
          }else{
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
                  </Grid>
                <Grid item sm={12} md={8} className={"box "+ classes.gridItem}>
                  {lists[0][1].map(title=>{
                    return <TitleSummary key={title.ISBN} {...title} createCart={createCart} match={match}/>
                    })}
                  {viewmore}
                </Grid>
         </Grid>
         </div>


        )
    }

}    

SearchPage.propTypes = {
    loadClientPending: PropTypes.func,
    classes: PropTypes.object,
    lists: PropTypes.array,
    slider: PropTypes.object,
    match: PropTypes.object,
  };

const mapStateToProps = (state)=>{
return {
    lists: state.titles.lists,
    slider: state.viewer.slider,
    errors: state.titles.errors,
    pagination: state.titles.pagination,
    titlesProgress: state.titles.pending,
    catalog: state.viewer.catalog,
    browse: state.viewer.browse
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