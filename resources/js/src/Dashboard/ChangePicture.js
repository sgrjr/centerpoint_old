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
  },

  fileUploadWrapper:{
  	position: "relative",
  	width: "100%",
  	height: "60px",

  	"&:after":{
  	  content: "attr(data-text)",
	  fontSize: "18px",
	  position: "absolute",
	  top: 0,
	  left: 0,
	  background: "#fff",
	  padding: "10px 15px",
	  display: "block",
	  width: "calc(100% - 40px)",
	  pointerEvents: "none",
	  zIndex: "20",
	  height: "40px",
	  lineHeight: "40px",
	  color: "#999",
	  borderRadius: "5px 10px 10px 5px",
	  fontWeight: 300
  	},

  	"&:before":{
		content: "Upload",
		position: "absolute",
		top: 0,
		right: 0,
		display: "inline-block",
		height: "60px",
		background: "#4daf7c",
		color: "#fff",
		fontWeight: 700,
		zIndex: 25,
		fontSize: "16px",
		lineHeight: "60px",
		padding: "0 15px",
		textTransform: "uppercase",
		pointerEvents: "none",
		borderRadius: "0 5px 5px 0"
  	},

  	":hover:before": {
  		background: "#3d8c63"
  	}
  },

  input: {
	opacity: 0,
	position: "absolute",
	top: 0,
	right: 0,
	bottom: 0,
	left: 0,
	zIndex: 99,
	height: "40px",
	margin: 0,
	padding: 0,
	display: "block",
	cursor: "pointer",
	width: "100%",
	border:"solid 2px gray"
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

  let uploadButton = null

  if(uploadState){
  	uploadButton =  <button type="button" className="btn btn-success btn-block" onClick={()=>{handleClose(); upload(props)}}>Upload</button>
  }

  return (<React.Fragment><Grid item>
            <Image src={user.photo} style={{backgroundColor:"gray",width:"150px", height:"150px", border:"solid 1px gray", margin:"auto"}} name="profileImage" />
              </Grid>
              <Grid item>
              <Button variant="contained" color="primary" onClick={handleClickOpen}>
                Change Picture
              </Button>
              <Dialog open={open} onClose={handleClose} className={classes.root}>
                <DialogTitle id="simple-dialog-title">Change Profile Picture</DialogTitle>
                <form name="photo" className={classes.uploadForm}>
                  <Image src={photo.imageSource} name="imageSource" style={{width:"150px"}} />
                <div className={classes.fileUploadWrapper} data-text="Select your file!">
                	<input className={classes.input} type="file" name="selectedFile" onChange={(e)=>{
                		updateForm(e);
                		toggleUpload(e);
                	}}/>
                	
                </div>
               {uploadButton}
                <LinearProgress variant="determinate" value={photo.completed} color="secondary" />
                {photo.errors.selectedFile}
                </form>
              </Dialog>
              </Grid>
      </React.Fragment>
  );
}
