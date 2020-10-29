import { makeStyles } from '@material-ui/core/styles';

const useStyles = makeStyles(theme => ({
  grow: {
    flexGrow: 1,
  },
  menuButton: {
    marginRight: theme.spacing(2),
  },
  title: {
    [theme.breakpoints.up('sm')]: {
      display: 'block',
    },
    width:"100%"
  },
  inputRoot: {
    color: 'inherit',
  },
  inputInput: {
    padding: theme.spacing(1, 1, 1, 7),
    transition: theme.transitions.create('width'),
    width: '100%',
    [theme.breakpoints.up('md')]: {
      width: 200,
    },
  },
  list: {
    width: 250
  },
  fullList: {
    width: 'auto',
  },
  menuItem: {display:"block", clear:"both", padding: "15px"}
}));

export default useStyles;