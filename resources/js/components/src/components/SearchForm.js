import React from 'react';
import Paper from '@material-ui/core/Paper';
import InputBase from '@material-ui/core/InputBase';
import IconButton from '@material-ui/core/IconButton';
import SearchIcon from '@material-ui/icons/Search';
import MenuItem from '@material-ui/core/MenuItem';
import FormControl from '@material-ui/core/FormControl';
import Select from '@material-ui/core/Select';
import { withStyles } from "@material-ui/core/styles"
import { connect } from 'react-redux'
import PropTypes from 'prop-types';
import actions from '../actions';

const useStyles = theme => ({
    searchForm: {
        padding: '1px 2px',
        display: 'flex',
        alignItems: 'center',
        boxShadow: "none",
        background : "transparent",
        height:"75px",
        marginBottom:"15px"
      },
      input: {
        borderBottom: "1px solid gray",
        width: "50%"
      },
      iconButton: {
        padding: 5,
        border:"none",
        background : "transparent"
      }
});

class SearchForm extends React.Component {
    render() {
        const { search, csrf, classes, searchfilters, searchfilter } = this.props;

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
            <Paper component="form" className={classes.searchForm}>
              
            <FormControl className={classes.iconButton}>
                <input type="hidden" name="csrf" value={csrf}/>
              <Select
                labelId="demo-simple-select-label"
                id="demo-simple-select"
                value={searchfilter}
                onChange={handleChange}
              >
                  {searchfilters.map(function(filter){
                    return <MenuItem  className={classes.menuItem} key={filter} value={filter}>{filter}</MenuItem>
                  })}
                
              </Select>
            </FormControl>
      
            <InputBase
              className={classes.input}
              placeholder={"Search by " + searchfilter +"..."}
              inputProps={{ 'aria-label': search}}
              onChange={handleTextChange}
              value={search}
            />
            <IconButton type="submit" onClick={submitSearch} className={classes.iconButton} aria-label="search">
              <SearchIcon />
            </IconButton>
          </Paper>
        );
    }
}

const form = withStyles(useStyles)(SearchForm);

form.propTypes = {
    classes: PropTypes.object,
    searchfilter: PropTypes.string,
    searchfilters: PropTypes.array,
    search: PropTypes.string,
  };
  
  const mapStateToProps = (state)=>{
    return {
      searchfilters: state.application.searchfilters,
      searchfilter: state.application.searchfilter,
      search: state.application.search,
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
  
  export default connect(mapStateToProps, mapDispatchToProps)(form)