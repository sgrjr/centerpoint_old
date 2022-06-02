import React from 'react';
import Button from '@material-ui/core/Button';
import Grid from '@material-ui/core/Grid';
import DialogTitle from '@material-ui/core/DialogTitle';
import Dialog from '@material-ui/core/Dialog';
import LinearProgress from '@material-ui/core/LinearProgress';
import Image from '../components/Image'
import { makeStyles } from '@material-ui/core/styles';

const useStyles = makeStyles({
  root: {
  	position: "absolute",
	top: 0,
	right: 0,
	bottom: 0,
	left: 0,
	boxAlign: "center",
	alignItems: "center",
	display: "box",
	display: "flex",
	boxPack: "center",
	justifyContent: "center",
 // 	backgroundImage: "-webkit-linear-gradient(bottom left, #bf7a6b 0%, #e6d8a7 100%)",
  //	backgroundImage: "linear-gradient(to top right,#bf7a6b 0%, #e6d8a7 100%)"
  },

  uploadForm: {
  	width: "400px"
  }
});

export default function ChangePicture(props) {
  const classes = useStyles();

  const [open, setOpen] = React.useState(false);
  const [uploadState, toggleUpload] = React.useState(false);
  const { user, photo, updateForm } = props

  const handleClickOpen = () => {
    setOpen(true);
  };

  const handleClose = value => {
    setOpen(false);
  };

  const upload = (props)=>{
    props.uploadFile(props.photo.selectedFile)
  }

  const reset = () => {
    props.updateForm(false);
  };

  let uploadButton = null

  if(uploadState){
  	uploadButton = <><button className={"can-save-"+uploadState} onClick={(e)=>{e.preventDefault(); handleClose(); upload(props)}}>Save</button><button type="button" onClick={(e)=>{reset(); handleClose(); }}>Cancel</button></>
  }

  let image = null

  if(photo && photo.imageSource && photo.imageSource != "" && photo.imageSource != false){
  	image = <Image src={photo.imageSource} name="imageSource" style={{width:"150px"}} />
  }else if(user && user.photo){
  	image = <Image src={user.photo} name="imageSource" style={{width:"150px"}} />
  }

  return (<React.Fragment><Grid item>
            <Image src={user && user.photo? user.photo:"/"} style={{backgroundColor:"gray", border:"solid 1px gray", margin:"auto"}} name="profileImage" />
              </Grid>
              <Grid item>
              <button onClick={handleClickOpen}>
                Change Picture
              </button>
              <Dialog open={open} onClose={handleClose} className={classes.root}>
                <DialogTitle id="simple-dialog-title">Change Profile Picture</DialogTitle>
                <form name="photo" className={classes.uploadForm}>
                  {image}
                <div data-text="Select your file!">
                	<input type="file" name="selectedFile" onChange={(e)=>{
                		updateForm(e);
                		toggleUpload(e);
                	}}/>
                	
                </div>
               {uploadButton}
                <LinearProgress variant="determinate" value={photo.completed? photo.completed.length:0} color="secondary" />
                {photo.errors.selectedFile}
                </form>
              </Dialog>
              </Grid>
      </React.Fragment>
  );
}
