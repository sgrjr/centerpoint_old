import React from 'react';
import Avatar from '@material-ui/core/Avatar';
import Button from '@material-ui/core/Button';
import CssBaseline from '@material-ui/core/CssBaseline';
import TextField from '@material-ui/core/TextField';
import FormControlLabel from '@material-ui/core/FormControlLabel';
import Checkbox from '@material-ui/core/Checkbox';
import Link from '@material-ui/core/Link';
import Grid from '@material-ui/core/Grid';
import IconPicker from '../components/IconPicker';
import Typography from '@material-ui/core/Typography';
import Container from '@material-ui/core/Container';
import { connect } from 'react-redux'
import PropTypes from 'prop-types';
import actions from '../actions';
import {Navigate,useParams } from 'react-router-dom';
import Progress from '../components/SubtleProgress';


class SigninPage extends React.Component {
  
  handleSubmit(e){
    const input = Object.assign({},this.props.login,{
      token: null
    })
    this.props.attemptLogin(input)
  }

  render(){

    if(this.props.viewer.KEY !== undefined ){
      const {search } = this.props.params
      const redirect = search? search.replace("?return=",""):"/"
      return <Navigate to={redirect} />
    }else{
      
      const { classes, login, updateForm } = this.props;

      let form = ()=>{
        return ( <form name="login" id="login">

          <h2 style={{color:"red"}}>{login? login.errors.general:""}</h2>

          <p style={{color:"red"}}>{login? login.errors.email:""}</p>
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
          <p style={{color:"red"}}>{login? login.errors.password:""}</p>
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
            className={"submit"}
            onClick={this.handleSubmit.bind(this)}
          >
            Sign In
          </Button>
          <Grid container>
            <Grid item xs>
              <Link to="#" variant="body2">
                Forgot password?
              </Link>
            </Grid>
            <Grid item>
              <Link to="#" variant="body2">
                {"Don't have an account? Sign Up"}
              </Link>
            </Grid>
          </Grid>
        </form>)
      }

      if(this.props.viewer.pending){
        form = ()=>{ return (<Progress color="primary"/>) } 
      }

    return <>{this.props.navigation}<Container component="main" maxWidth="xs">
      <CssBaseline />
      <div className="signin">
        <Avatar className={"avatar"}>
          <IconPicker icon="lockOutlined" />
        </Avatar>
        <Typography component="h1" variant="h5">
          Sign In
        </Typography>
       {form()}
      </div>
    </Container></>
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

const SignIn = (props) => {
  return <SigninPage {...props} params={useParams()} />
}

  export default connect(mapStateToProps, mapDispatchToProps)(SignIn)

