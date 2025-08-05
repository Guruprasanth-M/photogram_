<pre>
<?
if(isset($_GET['rows'])){
$rows = $_GET['rows'];
$cmd = "./a.out $rows";
print($cmd);
system($cmd);

}else{
    printf("set parameter in url");
}

?>
</pre>