import React from 'react';
import Button from '@material-ui/core/Button';
import Grid from '@material-ui/core/Grid';
import DialogTitle from '@material-ui/core/DialogTitle';
import Dialog from '@material-ui/core/Dialog';
import LinearProgress from '@material-ui/core/LinearProgress';
import Image from '../components/Image'

export default function ChangePicture(props) {

  const [open, setOpen] = React.useState(false);

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

  return (<React.Fragment><Grid item>
            <Image src={user.photo} style={{width:"150px"}} name="profileImage" />
              </Grid>
              <Grid item>
              <Button variant="contained" color="primary" onClick={handleClickOpen}>
                Change Picture
              </Button>
              <Dialog open={open} onClose={handleClose} >
                <DialogTitle id="simple-dialog-title">Change Profile Picture</DialogTitle>
                <form name="photo">
                  <Image src={photo.imageSource} name="imageSource" style={{width:"150px"}} />
                <input type="file" name="selectedFile" onChange={updateForm}/>
                <button type="button" className="btn btn-success btn-block" onClick={()=>{handleClose(); upload(props)}}>Upload</button>
                <LinearProgress variant="determinate" value={photo.completed} color="secondary" />
                {photo.errors.selectedFile}
                </form>
              </Dialog>
              </Grid>
      </React.Fragment>
  );
}
