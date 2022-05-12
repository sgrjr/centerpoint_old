import React from 'react';
import PropTypes from 'prop-types';
import Typography from '@material-ui/core/Typography';

export default function Card(props) {
  return (
    <React.Fragment>
      <Typography component="h2" variant="h6" gutterBottom style={{backgroundColor:"#008afc", paddingLeft:"10px", color:"white"}}>
        {props.title}
      </Typography>

      {props.children}
    </React.Fragment>
  );
}

Card.propTypes = {
  children: PropTypes.node,
};
