<?php
	//$config = new JConfig();
   // $sql = ADONewConnection($engine);
   // $sql->debug = $config->debug;
	//$sql->autoRollback = $config->autoRollback;
   // $db = $sql->Connect($server, $username, $password, $database); +++


    $session = new Session();
    if(empty( $session->get('publickey'))){
      //  $session->set( 'publickey',  Execute());
       // var_dump('publickey',$session->get('publickey'));
    }
    //var_dump(base64_decode( $session->get('publickey'))); die;
    // $encrypted=  RSAEncryption('qw', $session->get('publickey'));
    // var_dump($encrypted)     ;
    // $res=  Execute('t=788&y=uu' ) ;
    // var_dump('res',$res);die;
    // }
    function createKeys (){
        $myRSAEncryptor= new phpseclib\Crypt\RSA();
        extract( $myRSAEncryptor->createKey());
        $r= fopen('api/8000.key','w') ;
        fwrite($r,$privatekey);
        fclose($r);
       // var_dump( $privatekey);
        $r= fopen('api/8000.csr','w') ;
        fwrite($r,$publickey);
        fclose($r);
        //var_dump( $publickey);
        die;
    }

    function RSAEncryption($strTextToEncrypt,$gpgpsRSAPublicKey){
        //$myRSAEncryptor= new phpseclib\Crypt\RSA();
        //$myRSAEncryptor->setEncryptionMode(phpseclib\Crypt\RSA::ENCRYPTION_PKCS1);
        //$myRSAEncryptor->loadKey(base64_decode( $gpgpsRSAPublicKey));
        //$ciphertext = base64_encode(($myRSAEncryptor->encrypt($strTextToEncrypt)));
        //return $ciphertext;
        return encrypt_message($strTextToEncrypt,$gpgpsRSAPublicKey);
    }

    function RSADecryption($data,$gpgpsRSAPublicKey) {
        //$rsa = new phpseclib\Crypt\RSA();
        //$rsa->setEncryptionMode( phpseclib\Crypt\RSA::ENCRYPTION_PKCS1);
        //$rsa->loadKey(base64_decode($gpgpsRSAPublicKey)); //private key in xml
        //// decrypt key  for aes decryption
        //$aes_key = $rsa->decrypt(base64_decode($data));
        //return $aes_key;
        return decrypt_message($data,$gpgpsRSAPublicKey) ;
    }
    function encrypt_message($plaintext,$asym_key,$key_length=150)
	{
        $rsa = new  \phpseclib\Crypt\RSA();
        $rij = new \phpseclib\Crypt\Rijndael();
        $rand= new \phpseclib\Crypt\Random();
	    // Generate Random Symmetric Key
	    $sym_key = $rand::string($key_length);
	    // Encrypt Message with new Symmetric Key
	    $rij->setKey($sym_key);
	    $ciphertext = $rij->encrypt($plaintext);
	    $ciphertext = base64_encode($ciphertext);
	    // Encrypted the Symmetric Key with the Asymmetric Key
	    $rsa->loadKey(base64_decode($asym_key));
	    $sym_key = $rsa->encrypt($sym_key);

	    // Base 64 encode the symmetric key for transport
	    $sym_key = base64_encode($sym_key);
	    $len = strlen($sym_key); // Get the length

	    $len = dechex($len); // The first 3 bytes of the message are the key length
	    $len = str_pad($len,3,'0',STR_PAD_LEFT); // Zero pad to be sure.

	    // Concatenate the length, the encrypted symmetric key, and the message
	    $message = $len.$sym_key.$ciphertext;
      //  var_dump('length',$len,'key',$sym_key,'text',$ciphertext);
        return $message;
	}
    function decrypt_message($message,$asym_key)
	{
        $rsa = new  \phpseclib\Crypt\RSA();
        $rij = new \phpseclib\Crypt\Rijndael();
        // Extract the Symmetric Key
        $len = substr($message,0,3);
	    $len = hexdec($len);
	    $sym_key = substr($message,3,$len);
	    //Extract the encrypted message
	    $message = substr($message,3);
	    $ciphertext = substr($message,$len);
	    $ciphertext = base64_decode($ciphertext);
	    // Decrypt the encrypted symmetric key
	    $rsa->loadKey(base64_decode($asym_key));
	    $sym_key = base64_decode($sym_key);
	    $sym_key = $rsa->decrypt($sym_key);

	    // Decrypt the message
	    $rij->setKey($sym_key);
	    $plaintext = $rij->decrypt($ciphertext);

		return $plaintext;
    }
    function empty2blank(array $arr) {
        array_walk($arr, function(&$val, $key) {
            if (empty($val)) {
                $val = is_array($val) ? '[]' : '';
            } elseif (is_array($val)) {
                $val = empty2blank($val);
            }
        });
        return $arr;
    }
    function getnamespace($file){
        global $viewpage;
        $filearr=explode('\\',$file);
        if ( in_array('public', $filearr)){
            //  var_dump   ($filearr[ count( $filearr)-2] .'\\'. $viewpage);  die;
            return  $filearr[ count( $filearr)-2] .'\\'.   ( ($viewpage)? $viewpage : 'home');
        }
        return false;
    }

    function isJson($string) {
      $result=  json_decode($string);
      if((json_last_error() == JSON_ERROR_NONE)){
          return $result;
      }
      return $string;
    }
    function Execute( array  $data=[]){
        $params = $data ;
        if (!isset($params['actions'])){
			foreach($_POST as $key=> $value){
				$params[$key]=$value ;
			}

            $key = array_search(__FUNCTION__, array_column(debug_backtrace(), 'function'));
            $file= debug_backtrace()[$key]['file']         ;
            if (getnamespace($file)){
                $params['actions']= getnamespace($file);
            }
        }else{
			if(count($params,COUNT_NORMAL)==1){
				$params = $_POST ;
				$params['actions'] = $data['actions'] ;
			}
		}

        //var_dump(http_build_query (empty2blank( $params)));
        global $serverURL;
		// Send through Curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $serverURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch, CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, (empty2blank( $params)));
       // ($params) ? array('rsadata'=> RSAEncryption(http_build_query (empty2blank( $params)) , $_SESSION['publickey'])) : $params);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $result = trim(curl_exec($ch));
        $err = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
        //var_dump($httpCode);
        curl_close($ch);
        if ($err || $httpCode==404 ){
           exit($err.' Connection Down') ;
        }else{
            return isJson($result) ;
        /*   if($_SESSION['publickey']){
               $final =   isJson( RSADecryption((isJson($result)), $_SESSION['publickey']));
             return   $final?  $final : $result;
        }else{
            return isJson($result) ;
        }*/
        }

	}
    //}
