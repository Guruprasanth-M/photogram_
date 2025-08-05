<?php

$time = microtime(true);
$options = [
    // Increase the bcrypt cost from 12 to 13.
    'cost' => 31,
];
echo password_hash("rasmuslerdorf", PASSWORD_BCRYPT, $options);

print("\n"."Took ".microtime(true) - $time." Sec"."\n"); 

// if(password_verify("rasmuslerdorf", '$2y$13$.4Um4ezR2GRBRg8QqR5H6eM/zP903M4q7j9t7CQWMbQKmsFJOJ5Va')){
//     echo("\n"."correct"."\n");
// }else{
//     echo("\n"."wrong"."\n");

// }
