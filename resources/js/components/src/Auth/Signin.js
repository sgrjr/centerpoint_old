import React from 'react';
import Avatar from '@material-ui/core/Avatar';
import Button from '@material-ui/core/Button';
import CssBaseline from '@material-ui/core/CssBaseline';
import TextField from '@material-ui/core/TextField';
import FormControlLabel from '@material-ui/core/FormControlLabel';
import Checkbox from '@material-ui/core/Checkbox';
import Link from '@material-ui/core/Link';
import Grid from '@material-ui/core/Grid';
import LockOutlinedIcon from '@material-ui/icons/LockOutlined';
import Typography from '@material-ui/core/Typography';
import Container from '@material-ui/core/Container';
import { connect } from 'react-redux'
import PropTypes from 'prop-types';
import actions from '../actions';
import {Redirect} from 'react-router-dom';
import { withStyles } from '@material-ui/core';
import { withRouter } from "react-router";

const useStyles = theme => ({
  paper: {
    marginTop: theme.spacing(8),
    display: 'flex',
    flexDirection: 'column',
    alignItems: 'center',
  },
  avatar: {
    margin: theme.spacing(1),
    backgroundColor: theme.palette.secondary.main,
  },
  form: {
    width: '100%', // Fix IE 11 issue.
    marginTop: theme.spacing(1),
  },
  submit: {
    margin: theme.spacing(3, 0, 2),
  },
});

class SigninPage extends React.Component {
  
  handleSubmit(e){
    e.preventDefault();
    const input = Object.assign({},this.props.login,{
      token: null
    })
  
    this.props.attemptLogin(input)
  }

  render(){

    if(this.props.viewer !== false){
      const redirect = this.props.location.search? this.props.location.search.replace("?return=",""):"/"
      return <Redirect to={redirect} />
    }else{
      
      const { classes, login, updateForm } = this.props;

    return <Container component="main" maxWidth="xs">
      <CssBaseline />
      <div className={classes.paper}>
        <Avatar className={classes.avatar}>
          <LockOutlinedIcon />
        </Avatar>
        <Typography component="h1" variant="h5">
          Sign In
        </Typography>
        <form className={classes.form} name="login" id="login">
          <TextField
            variant="outlined"
            margin="normal"
            required
            fullWidth
            id="email"
            label="Email Address"
            name="email"
            autoComplete="email"
            autoFocus
            defaultValue={login.email}
            onChange={updateForm}
          />
          <TextField
            variant="outlined"
            margin="normal"
            required
            fullWidth

            name="password"
            label="Password"
            type="password"
            id="password"
            autoComplete="current-password"
            defaultValue={login.password}
            onChange={updateForm}
          />
          <FormControlLabel
            control={<Checkbox value="remember" color="secondary" />}
            label="Remember me"
          />
          <Button
            type="submit"
            fullWidth
            variant="contained"
            color="primary"
            className={classes.submit}
            onClick={this.handleSubmit.bind(this)}
          >
            Sign In
          </Button>
          <Grid container>
            <Grid item xs>
              <Link href="#" variant="body2">
                Forgot password?
              </Link>
            </Grid>
            <Grid item>
              <Link href="#" variant="body2">
                {"Don't have an account? Sign Up"}
              </Link>
            </Grid>
          </Grid>
        </form>
      </div>
    </Container>
  } }
}

SigninPage.propTypes = {
  viewer: PropTypes.object
};

const mapStateToProps = (state)=>{
  return {
    viewer: state.viewer,
    login: state.forms.login
    }
  }
  
  const mapDispatchToProps = dispatch => {
    return {
      attemptLogin: (input) => {
        dispatch(actions.auth.AUTH_GET.creator(input))
      },
      updateForm: (e, form) => {
        dispatch(actions.form.FORM_UPDATE.creator(e,form))
      }
    }
  }  

  export default withRouter(
    connect(
      mapStateToProps, mapDispatchToProps)(withStyles(useStyles)(SigninPage)
      )
    )