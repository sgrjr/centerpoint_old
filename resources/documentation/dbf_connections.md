# DBF CONNECTIONS

## Enable COM in php.ini

From PHP 5.4.5, COM and DOTNET is no longer built into the php core.you have to add COM support in php.ini:

[COM_DOT_NET]
extension=php_com_dotnet.dll
Otherwise you will see this in your error log: Fatal error: Class 'COM' not found

The extension is included with php 5.4.5 for Windows.

## Installing Provider

1. download Microsoft OLE DB Provider for Visual FoxPro 8.0: https://www.microsoft.com/en-us/download/details.aspx?id=32602
2. Data sources in Windows. 32 bit for the driver
3. Add source

## Connection String

