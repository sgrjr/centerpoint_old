import React from 'react';
import PropTypes from 'prop-types';
import Typography from '@material-ui/core/Typography';

export default function Card(props) {
  return (
    <div className={"card " + props.className}>
      <h2>{props.title}</h2>
      {props.children}
    </div>
  );
}

Card.propTypes = {
  children: PropTypes.node,
};
