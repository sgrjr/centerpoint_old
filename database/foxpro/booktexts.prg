USE "D:\CENTERPOINT\WEBINFO\rDATA\booktext.dbf" SHARED

SELECT "Booktext"
CURSORTOXML( [Booktext] , [C:\www\book\database\foxpro\booktexts.xml] , 1 , 0+2+8+512 , 0 , [1] )