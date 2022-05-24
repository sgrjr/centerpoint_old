<?php namespace App;

class Password extends BaseModel {

	protected $fillable = ["INDEX","KEY","LOGINS","DATEUPDATE","DATESTAMP","UPASS","MPASS","UNAME","SNAME","EMAIL","PIC","COMPANY","SEX","FIRST","MIDNAME","LAST","ARTICLE","TITLE","ORGNAME","STREET","SECONDARY","CITY","CARTICLE","STATE","COUNTRY","POSTCODE","NATURE","VOICEPHONE","EXTENSION","FAXPHONE","COMMCODE","MDEPT","MFNAME","TSIGNOFF","TIMESTAMP","TIMEUPDATE","CANBILL","TAXEXEMPT","PASSCHANGE","PRINTQUE","SENDEMCONF","SEARCHBY","MULTIBUY","SORTBY","FULLVIEW","SKIPBOUGHT","OUTOFPRINT","OPROCESS","OBEST","OADDTL","OVIEW","ORHIST","OINVO","EXTZN","INSOS","INREG","LINVO","NOEMAILS","ADVERTISE","PROMOTION","PASSDATE","EMCHANGE"];

	protected $table = "passwords";
	protected $primaryKey = 'KEY';
	protected $appends = [];
	
	public function getKeyAttribute(){return $this->attributes["KEY"];}
	public function getUpassAttribute(){return $this->attributes["UPASS"];}
	public function getEmailAttribute(){return $this->attributes["EMAIL"];}
	public function getUnameAttribute(){return $this->attributes["UNAME"];}

	public static function makeFromUser($user){
		$that = new static;
		$that->KEY = $user->key;
		$that->LOGINS = null;
		$that->DATEUPDATE = $user->created_at;
		$that->DATESTAMP = $user->created_at;
		$that->UPASS = $user->password;
		$that->MPASS = null;
		$that->UNAME = $user->email;
		$that->SNAME = $user->email;
		$that->EMAIL = $user->email;
		$that->PIC = null;
		$that->COMPANY = null;
		$that->SEX = null;
		$that->FIRST = $user->name;
		$that->MIDNAME = null;
		$that->LAST = null;
		$that->ARTICLE = null;
		$that->TITLE = null;
		$that->ORGNAME = null;
		$that->STREET = null;
		$that->SECONDARY = null;
		$that->CITY = null;
		$that->CARTICLE = null;
		$that->STATE = null;
		$that->COUNTRY = null;
		$that->POSTCODE = null;
		$that->TIMESTAMP = $user->updated_at;
		$that->TIMEUPDATE = $user->updated_at;;
		$that->NATURE = null;
		$that->VOICEPHONE = null;
		$that->EXTENSION = null;
		$that->FAXPHONE = null;
		$that->COMMCODE = null;
		$that->MFNAME = null;
		$that->TSIGNOFF = null;
		$that->CANBILL = null;
		$that->TAXEXEMPT = null;
		$that->PASSCHANGE = null;
		$that->PRINTQUE = null;
		$that->SEARCHBY = null;
		$that->MULTIBUY = null;
		$that->SORTBY = null;
		$that->FULLVIEW = null;
		$that->OPROCESS = null;
		$that->OBEST = null;
		$that->OADDTL = null;
		$that->OVIEW = null;
		$that->ORHIST = null;
		$that->OINVO = null;
		$that->EXTZN = null;
		$that->INSOS = null;
		$that->INREG = null;
		$that->LINVO = null;
		$that->NOEMAILS = null;
		$that->ADVERTISE = null;
		$that->PASSDATE = null;
		$that->EMCHANGE = null;

		return $that;
	}
}
