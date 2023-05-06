<?php
    session_start();    //start session
    if ($_REQUEST['logout']) {  // logout button
        // clear cookies
        setcookie('islogin',null,time()-1,'/');
        setcookie('name',null,time()-1,'/');
        // clear sessions
        session_unset();
        session_destroy();
        echo '<script>location="./index.html"</script>';
    } elseif ( $_REQUEST['edit']) { // edit client data
        echo '<script>location="./editFile.html"</script>';
    }
?>