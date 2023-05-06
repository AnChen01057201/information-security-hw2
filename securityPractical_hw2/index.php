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

    $memberArr = array();

    $id_file = fopen('id.txt','r');         // open id.txt
    while ($line = fgets($id_file)) {
        $arr=explode(",", $line);           // flip by space + store in array
        $newMember = new member($arr[0], $arr[1], $arr[2]);
        array_push($memberArr, $newMember); // store in array
    }
    fclose($id_file);   // close id.txt
    
    session_start();    // start session
    $getAccount = @$_POST['account'];
    $getPwd = @$_POST['password'];

    $isMember = false;
    foreach($memberArr as $mem){
        if($getAccount == $mem->account && hash("sha1", $getPwd) == $mem->hashPwd){ // compare account and password
            $isMember = true;
            setCookie('islogin', true, time()+3600,'/');    // login state
		    setCookie('name', $mem->name, time()+3600,'/'); // name
	        $_SESSION['account'] = $mem->account;   // account
	        $_SESSION['pwd'] = $mem->hashPwd;       // password
            echo '<script>alert("登入成功")</script>';
            echo '<script>location="./login.html"</script>';
        }
    }

    if(!$isMember){ // not member
        echo '<script>alert("登入失敗")</script>';
        echo '<script>location="./index.html"</script>';
    }

?>