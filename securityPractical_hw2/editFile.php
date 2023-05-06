<?php
    class member{
        var $account;   // account
        var $hashPwd;   // encrypted password
        var $name;      // member name
        function __construct($account, $hashPwd, $name){
            $this->account = $account;
            $this->hashPwd = $hashPwd;
            $this->name = $name;
        }
    }

    session_start();    // start session
    $getAccount = $_SESSION['account']; // account
    $getName = @$_POST['name'];         // name
    $getPwd = hash("sha1", @$_POST['password']);            // new password
    $getCheckPwd = hash("sha1", @$_POST['checkpassword']);  // check new password

    if($getPwd != $getCheckPwd){    // compare password
        echo '<script>alert("前後密碼不同")</script>';
        echo '<script>location="./editFile.html"</script>';
    }
    else{
        $memberArr = array();

        $id_file = fopen('id.txt','r');         // open id.txt with 'r'
        while ($line = fgets($id_file)) {       // get a line
            $arr=explode(",", $line);           // spilit by space + store in array
            $newMember = new member($arr[0], $arr[1], $arr[2]);
            array_push($memberArr, $newMember); // store in array
        }
        fclose($id_file);   // close file

        $id_file = fopen('id.txt','w');     //open id.txt
        $str = "";
        foreach($memberArr as $mem){
            if($getAccount == $mem->account){
                $str = $str.$mem->account.",".$getPwd.",".$getName.PHP_EOL; // new data
            }
            else{
                $str = $str.$mem->account.",".$mem->hashPwd.",".$mem->name; // old data
            }
        }
        $nullStr = "";
        fwrite($id_file, $nullStr); // clear id.txt
        fwrite($id_file, $str);     // write new data to id.txt
        fclose($id_file);           // close file
        // clear cookies
        setcookie('islogin',null,time()-1,'/');
        setcookie('name',null,time()-1,'/');
        // clear sessions
        session_unset();
        session_destroy();
        echo '<script>alert("請重新登入")</script>';
        echo '<script>location="./index.html"</script>';
    }
?>