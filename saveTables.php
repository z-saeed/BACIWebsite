<?php
require_once 'db_connect.php';

$header="";
$data="";
if (isset($_GET['tag'])){
    $tag=$_GET['tag'];

    if ($tag==1)
        $table = "user_tbl";

    if ($tag==2)
        $table = "country_tbl";
    
}


$select = "SELECT * FROM ".$table;

$colNames = "DESCRIBE ".$table;

$q = $con->query($colNames);
$q->execute();

$export = $con->prepare( $select ) or die ( "Sql error : " . mysql_error( ) );
$export->execute();

$fields = $export->columnCount();



for ( $i = 0; $i < $fields; $i++ )
{
    $header .= $q->fetchAll(PDO::FETCH_COLUMN) . ",";
}

while( $row = $export->fetch(PDO::FETCH_OBJ))
{
    $line = '';
    foreach( $row as $value )
    {                                            
        if ( ( !isset( $value ) ) || ( $value == "" ) )
        {
            $value = ",";
        }
        else
        {
            $value = str_replace( '"' , '""' , $value );
            $value = '"' . $value . '"' . ",";
        }
        $line .= $value;
    }
    $data .= trim( $line ) . "\n";
}
$data = str_replace( "\r" , "" , $data );

if ( $data == "" )
{
    $data = "\n(0) Records Found!\n";                        
}

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=".$table.".csv");
header("Pragma: no-cache");
header("Expires: 0");
print "$header\n$data";

?>