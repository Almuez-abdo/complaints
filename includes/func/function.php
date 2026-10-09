<?php

    //title function

    function getTitle(){
        global $pageTitle;
        if(isset($pageTitle)){
            echo $pageTitle;
        }else{
            echo 'No Title';
        }
    };

    // Redirect To Home
    
    function redirectHome($theMsg, $sec = 3, $url= NULL){
        if($url === NULL){
            $url = 'index.php';
            $link = 'الصفحة الرئيسية';
        }elseif($url === 'back'){
            if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ''){
                $url = $_SERVER['HTTP_REFERER'];
                $link = 'الصفحة السابقة';
            }
        }elseif($url == $url){
            $url = $url;
            $link = 'الصفحة الرئيسية '; 
        }
     
    

        echo '<div class= "container text-end">';
            echo $theMsg ;
            echo '<div class= "alert alert-info">سوف يتم تحويلك الي  ' .  $link . ' بعد ' . $sec . ' ثانية </div>';
        echo '</div>';
        header("refresh:$sec;URL= $url");
        exit();
    };

