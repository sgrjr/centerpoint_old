export default new function Time(){
	const month = ["January","February","March","April","May","June","July","August","September","October","November","December"];
	const d = new Date();

	return {
		currentMonthName: month[d.getMonth()]
	}
}