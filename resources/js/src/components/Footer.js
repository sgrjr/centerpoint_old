import React from 'react';
import PropTypes from 'prop-types';
import { makeStyles } from '@material-ui/core/styles';
import Container from '@material-ui/core/Container';
import Typography from '@material-ui/core/Typography';
import Link from '@material-ui/core/Link';
import { connect } from 'react-redux'

const useStyles = makeStyles(theme => ({
  footer: {
    backgroundColor: theme.palette.background.paper,
    // marginTop: theme.spacing(8),
    padding: theme.spacing(6, 0),
    marginTop: "50px"
  },
  footerImage : {
    width: "50px",
    margin: "auto auto"
  }
}));

const Footer = function(props) {
  const classes = useStyles();
  const { description, title } = props;

  return (
    <footer className={classes.footer + " noPrint"}>
      <Container maxWidth="lg">
        <Typography variant="h6" align="center" gutterBottom>
          <span id="footerlogo" className={classes.footerImage} />
        </Typography>
        <Typography variant="subtitle1" align="center" color="textSecondary" component="p">
          {description}
        </Typography>
        <Typography variant="body2" color="textSecondary" align="center">
          {'© '}
          {new Date().getFullYear()}
          {' '}
          <Link color="inherit" href="/">
            {title ?? "home"}
          </Link>
          {'.'}
        </Typography>
      </Container>
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