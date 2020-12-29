<?php
add_action('wp_head', 'add_yandex_metrika', 10);
//add_action('wp_footer', 'add_yandex_goals', 99);

function add_yandex_metrika(){

   $metrika = (string)'
   <!-- Yandex.Metrika counter -->
    
    <!-- /Yandex.Metrika counter -->';
    echo $metrika;
}


function add_yandex_goals(){
    $goals = (string)'
   <!-- Yandex.goals -->
    
    <!-- /Yandex.goals -->';
    echo $goals;
}
