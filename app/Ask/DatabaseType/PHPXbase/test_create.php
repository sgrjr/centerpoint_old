<?
/**
* ----------------------------------------------------------------
*			XBase
*			test_create.php	
* --------------------------------------------------------------
*
* Demonstration how to create a dbf from scratch
*
**/

	/* load the required classes */
	require_once "Column.class.php";
	require_once "Record.class.php";
	require_once "Table.class.php";
	require_once "XBaseWritableTable.class.php";

	/* sample data */	
	$fields = array(
		array("bool" , $this->types->DBFFIELD_TYPE_LOGICAL),
		array("memo" , $this->types->DBFFIELD_TYPE_MEMO),
		array("date" , $this->types->DBFFIELD_TYPE_DATE),
		array("number" , $this->types->DBFFIELD_TYPE_NUMERIC, 3, 0),
		array("string" , $this->types->DBFFIELD_TYPE_CHAR, 50),
	);
	
	/* create a new table */
	$tableNew = XBaseWritableTable::create("test/created.dbf",$fields);
	
	/* insert some data */
	$r =& $tableNew->appendRecord();
	$r->setObjectByName("bool",true);
	$r->setObjectByName("date",time());
	$r->setObjectByName("number",123);
	$r->setObjectByName("string","String one");
	$tableNew->writeRecord();
	
	$r =& $tableNew->appendRecord();
	$r->setObjectByName("bool",false);
	$r->setObjectByName("date",time()/2);
	$r->setObjectByName("number",321);
	$r->setObjectByName("string","String two");
	$tableNew->writeRecord();

	$r =& $tableNew->appendRecord();
	$r->setObjectByName("bool",true);
	$r->setObjectByName("date",time()-(60*60*24));
	$r->setObjectByName("number",111);
	$r->setObjectByName("string","String trio");
	$tableNew->writeRecord();
	
	/* close the table */
	$tableNew->close();
	
	/* open created file*/
	$table =& new XBaseTable("test/created.dbf");
	$table->open();

    /* xml output */
    echo $table->toHTML();
    echo "<pre>\n";
    echo htmlspecialchars($table->toXML());
    echo "</pre>\n";

	/* close the table */
	$table->close();
?>