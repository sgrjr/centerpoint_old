import React from 'react';
import Paper from '@material-ui/core/Paper';
import InputBase from '@material-ui/core/InputBase';
import IconButton from '@material-ui/core/IconButton';
import IconPicker from '../components/IconPicker';
//import MenuItem from '@material-ui/core/MenuItem';
//import FormControl from '@material-ui/core/FormControl';
//import Select from '@material-ui/core/Select';
//import { withStyles } from "@material-ui/core/styles"
import { connect } from 'react-redux'
import PropTypes from 'prop-types';
import actions from '../actions';
import {useParams} from 'react-router-dom'
import styles from '../styles.js'

class SearchForm extends React.Component {
    componentDidUpdate(prevProps){
      if(prevProps.search !== this.props.search || prevProps.searchFilter !== this.props.searchFilter){
        if(this.props.search.trim() !== "" && !this.props.authPending){
          this.props.submitSearch()
        }
      }
      
    }

    render() {
        const { search, searchFilters, searchFilter, params } = this.props;

        const handleChange = event => {
          this.props.updateSearchFilter(event.target.value);
        };

        const handleTextChange = event => {
          this.props.updateSearch(event.target.value);
        }

        const submitSearch = event => {
          event.preventDefault()
          this.props.submitSearch()
        }

        return (
            <div className={styles.searchForm}>
            <form>
              <select
                label-id={styles.formSelect}
                id={styles.formSelect}
                className={styles.formSelect}
                value={searchFilter}
                onChange={handleChange}
              >
                  {searchFilters.map(function(filter){
                    return <option key={filter[0]} value={filter[0]}>{filter[1]}</option>
                  })}
                
              </select>
               <input
              id={styles.searchInput}
              placeholder={"Search by " + searchFilter +"..."}
              aria-label={"search"}
              onChange={handleTextChange}
              value={search}
            />
            <button type="submit" onClick={submitSearch} className={styles.iconButton} aria-label="search">
              <IconPicker icon="search" />
            </button>
            </form>
      
           
          </div>
        );
    }
}

SearchForm.propTypes = {
    searchFilter: PropTypes.string,
    searchFilters: PropTypes.array,
    search: PropTypes.string
  };
  
  const mapStateToProps = (state)=>{
    return {
      searchFilters: state.application.searchFilters,
      searchFilter: state.application.searchFilter,
      search: state.application.search,
      authPending: state.viewer.pending
         }
    }

    const mapDispatchToProps = dispatch => {
      return {
        updateSearchFilter: (filter) => {
          dispatch(actions.search.SEARCH_UPDATE_FILTER.creator(filter))
        },
        updateSearch: (input) => {
          dispatch(actions.search.SEARCH_UPDATE.creator(input))
        }
      }
    }

  export default connect(mapStateToProps, mapDispatchToProps)(SearchForm)