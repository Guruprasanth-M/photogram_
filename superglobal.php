<pre>
<?php

include 'libs/load.php';


print("_SERVER :\n");
print_r($_SERVER);
/*print("_GET :\n");
print_r($_GET);
print("_POST :\n");
print_r($_POST);
print("_FILES :\n");
print_r($_FILES);
print("_COOKIE :\n");
print_r($_COOKIE);*/
print("_SESSION :\n");
print_r($_SESSION);//we can persist data accross request.
printf("PRINTING A : ".$a);

if (isset($_GET['clear'])) {
    printf("clearing....\n");
    session::unset();
}
if (session::isset('a')){
    printf("A is already exists .... : ".session::get('a')."\n");
}else{
    session::set('a',time());
    printf("A is new value printing A : ".$_SESSION['a']."\n");
}
if (isset($_GET['destroy'])) {
    printf("destroying....\n");
    session::destroy();
}


?>
</pre>
