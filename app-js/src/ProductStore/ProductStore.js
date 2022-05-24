import React, { Component } from 'react';
import { connect } from 'react-redux'
import PropTypes from 'prop-types';
import Grid from '@material-ui/core/Grid';
import WelcomeSlider from './WelcomeSlider'
import actions from '../actions';
import HorizontalList from './HorizontalList'
import { withRouter } from "react-router";
import Image from '../components/Image'
import BrowseProducts from '../components/BrowseProducts'
import titlesQuery from './titlesQuery'

class ProductStore extends Component{

    componentDidMount(){
      this.props.titlesGet(titlesQuery()) 
    }

    render(){
        const { slider, lists } = this.props;
      
      const headers = {
        cp: {title: "Upcoming Titles", url:"/search/CENTE/INVNATURE", back:"#2e2e2e", displayHorizontal: true},
        trade: {title: "Trade Titles", url:"/search/TRADE/INVNATURE", back:"#2e2e2e", displayHorizontal: true},
        advanced: {title: "", url: null, back:"none", displayHorizontal: false}
      }
       
        let errors = null

       if(this.props.errors){
          errors = this.props.errors.map(function(er){
            return <li>{er.message}</li>;
          })
        }

        let titleLists = null
        if(lists){
        let i = 0;

          titleLists = lists.map(list=>{
            let name = list[0]
            let title = ""
            let url = ""
            let displayHorizontal = true
            let background = "none"

            if(headers[name] !== undefined){
              title = headers[name].title
              url = headers[name].url
              displayHorizontal = headers[name].displayHorizontal
              background = headers[name].back
            }
            
            i++;

            return <HorizontalList key={i} items={list[1]} listTitle={title} url={url} displayHorizontal={displayHorizontal} background={background} />
          })
        }
        
        return(
        <div>
       {errors}
       <WelcomeSlider slider={slider} />
        <Grid container >
                <Grid item xs={12} md={3}>
                  <a href={this.props.catalog.pdf_link} target="_BLANK" rel="noopener noreferrer">
                    <Image src={this.props.catalog.image_link} style={{"height":"209px", "width":"160px", margin:"auto", display:"block"}} alt=""/>
                  </a>
                  <BrowseProducts browse={this.props.browse} open={false}/>
                  </Grid>
                <Grid item xs={12} md={8}>
                  {titleLists}
                </Grid>
         </Grid>
         </div>
        )
    }
}    

ProductStore.propTypes = {
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
      }
    }
  }

export default withRouter(connect(mapStateToProps, mapDispatchToProps)(ProductStore))