import React, { Component } from 'react';
import { connect } from 'react-redux'
import PropTypes from 'prop-types';
import Grid from '@material-ui/core/Grid';
import WelcomeSlider from './WelcomeSlider'
import actions from '../actions';
import TitlesDisplay from './TitlesDisplay'
import Image from '../components/Image'
import OldWebsite from '../components/OldWebsite'
import ToggleWebsite from '../components/ToggleWebsite'

function TitleLists(props){


  if(!props.lists){
    return <div />
  }else{

      const headers = {
        cp: {title: "Current Month Titles", url:"/search/current/list", back:"#2e2e2e", displayHorizontal: true},
        trade: {title: "Trade Titles", url:"/search/TRADE/invnature", back:"#2e2e2e", displayHorizontal: true},
        advanced: {title: "Upcoming Titles", url: "/search/upcoming/list", back:"none", displayHorizontal: false}
      }

    return props.lists.map((list,index)=>{
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

            return <TitlesDisplay key={index} items={list[1].data} pageInfo={list[1].paginatorInfo} listTitle={title} 
            url={url} displayHorizontal={displayHorizontal} background={background} 
            addTitleToCart={props.addTitleToCart} 
            selectedCart={props.selectedCart}
            viewer={props.viewer} />
          })
  }

}

class ProductStore extends Component{

    componentDidMount(){
      if(!this.props.lists || this.props.lists.length === 0){
        this.props.titlesGet(this.props.query({first:24})) 
      }
    }

    render(){

        if(this.props.oldWebsite){
          return <><OldWebsite src="http://www.centerpointlargeprint.com"/></>
        }

        if(this.props.lists[0] && this.props.lists[0][0] === "search" && !this.props.titlesProgress){
          this.props.titlesGet(this.props.query({first:10})) 
        }

        const { slider, lists } = this.props;
       
        let errors = null

       if(this.props.errors){
          errors = this.props.errors.map(function(er){
            return <li>{er.message}</li>;
          })
        }

        let titleLists = <TitleLists lists={lists} viewer={this.props.viewer} selectedCart={this.props.selectedCart} addTitleToCart={this.props.addTitleToCart}/>
        
        return(
        <>
        
             
        {this.props.navigation}
        <ToggleWebsite />
       {errors}
       {/*<WelcomeSlider slider={slider} />*/}
        <Grid>
          {/*<Grid item xs={12} md={3}>
            <a href={this.props.catalog.pdf_link} target="_BLANK" rel="noopener noreferrer">
              <Image src={this.props.catalog.image_link} style={{"height":"209px", "width":"160px", margin:"auto", display:"block"}} alt=""/>
            </a>
            </Grid>*/}
            <Grid item xs={12} lg={8} style={{margin:"auto"}}>
              {titleLists}
            </Grid>

         </Grid>
         </>
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
    slider: state.application.slider,
    errors: state.titles.errors,
    pagination: state.titles.pagination,
    titlesProgress: state.titles.pending,
    catalog: state.application.catalog,
    query: state.titles.query,
    selectedCart: state.viewer && state.viewer.cart? state.viewer.cart.selectedCart:false,
    viewer: state.viewer,
    oldWebsite: state.application.oldWebsite
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
      addTitleToCart: (query) => {
        dispatch(actions.cart.POST_TITLE_TO_CART.creator(query))
      }
    }
  }

export default connect(mapStateToProps, mapDispatchToProps)(ProductStore)