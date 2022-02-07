import { useLocation, useNavigate, useParams } from "react-router-dom";

export default function WithRouter( Child ) {
  return ( props ) => {
    const location = useLocation();
    const navigate = useNavigate();
    const params = useParams();
    return <Child { ...props } navigate={ navigate } params={params} location={ location } />;
  }
}