import React from 'react';
import PropTypes from 'prop-types';
import Container from '@material-ui/core/Container';
import Typography from '@material-ui/core/Typography';
import Link from '@material-ui/core/Link';
import { connect } from 'react-redux'
import styles from '../styles'
import './Footer.scss'

const Footer = function(props) {
  const { description, title } = props;

  return (
    <footer className={styles.footer}>

      <section>
        <ul>
          <li>CENTER POINT LARGE PRINT INC.</li>
          <li>LARGE PRINT PUBLISHER</li>
          <li></li>
          <li>600 BROOKS ROAD</li>
          <li>KNOX, MAINE 04986</li>
          <li>TOLL FREE: 1-800-929-9108</li>
          <li>FAX: 1-207-568-3727</li>
        </ul>
        <ul>
          <li><a href="#">Shop</a></li>
          <li><a href="#">FAQ</a></li>
          <li><a href="#">Shipping & Returns</a></li>
          <li><a href="#">Payment Methods</a></li>
        </ul>
      </section>

      <section><p>© 2022 by CENTER POINT LARGE PRINT</p></section>
    </footer>
  );
}

Footer.propTypes = {
  description: PropTypes.string,
  title: PropTypes.string,
};

const mapStateToProps = (state)=>{
  return {
      title: state.viewer.domain,
      description: state.viewer.appdescription
       }
  }
  
  export default connect(mapStateToProps)(Footer)