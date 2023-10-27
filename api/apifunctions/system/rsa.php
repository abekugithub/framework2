<?php
namespace system;
/**
 * rsa short summary.
 *
 * rsa description.
 *
 * @version 1.0
 * @author Solomon
 */
class rsa    extends \REST
{


    function __construct()
    {
        parent::__construct();
    }
    function RSADecryption($key) {
     //   $rsa = new \phpseclib\Crypt\RSA();
     // //  define('CRYPT_RSA_PKCS15_COMPAT', true);
     //   $rsa->setEncryptionMode( \phpseclib\Crypt\RSA::ENCRYPTION_PKCS1);
     //   $RSAPrivateKey = file_get_contents('8000.key', FILE_USE_INCLUDE_PATH);
     //    $rsa->loadKey($RSAPrivateKey); //private key in xml
     //   // decrypt key and iv for aes decryption
     //   $aes_key = $rsa->decrypt(base64_decode($key));
     //// var_dump($aes_key);
     //   //  $aes_iv = $rsa->decrypt(base64_decode($iv));
     //   return $aes_key;

        return $this->decrypt_message($key, file_get_contents('8000.key', FILE_USE_INCLUDE_PATH));
    }
    function RSAEncryption($strTextToEncrypt){
        //$myRSAEncryptor= new \phpseclib\Crypt\RSA();
        //$myRSAEncryptor->setEncryptionMode(\phpseclib\Crypt\RSA::ENCRYPTION_PKCS1) ;
        //$RSAPrivateKey = file_get_contents('8000.key', FILE_USE_INCLUDE_PATH);
        //$myRSAEncryptor->loadKey($RSAPrivateKey);
        //$strTextToEncrypt=  ( is_array($strTextToEncrypt)|| is_object($strTextToEncrypt)) ? json_encode(  $strTextToEncrypt):  $strTextToEncrypt;
        //$ciphertext = base64_encode(($myRSAEncryptor->encrypt($strTextToEncrypt)));
        //return         $ciphertext;
        return $this->encrypt_message ($strTextToEncrypt,file_get_contents('8000.key', FILE_USE_INCLUDE_PATH));
    }
    function encrypt_message($plaintext,$asym_key,$key_length=150)
	{
        $plaintext=  ( is_array($plaintext)|| is_object($plaintext)) ? json_encode(  $plaintext):  $plaintext;
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
	    $rsa->loadKey($asym_key);
	    $sym_key = $rsa->encrypt($sym_key);

	    // Base 64 encode the symmetric key for transport
	    $sym_key = base64_encode($sym_key);
	    $len = strlen($sym_key); // Get the length

	    $len = dechex($len); // The first 3 bytes of the message are the key length
	    $len = str_pad($len,3,'0',STR_PAD_LEFT); // Zero pad to be sure.

	    // Concatenate the length, the encrypted symmetric key, and the message
	    $message = $len.$sym_key.$ciphertext;
     //   $this->response(['length'=>$len,'key'=>$sym_key,'text'=>$ciphertext],200);
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
	    $rsa->loadKey($asym_key);
        $sym_key = base64_decode($sym_key);
	    $sym_key = $rsa->decrypt($sym_key);

	    // Decrypt the message
	    $rij->setKey($sym_key);
	    $plaintext = $rij->decrypt($ciphertext);

		return $plaintext;
	}











    //function decrypt_message($message,$asym_key)
    //{

    //   $rsa = new  \phpseclib\Crypt\RSA();
    //   $rij = new \phpseclib\Crypt\Rijndael();

    //   // Extract the Symmetric Key
    //   $len = substr($message,0,3);
    //    $len = hexdec($len);
    //    $sym_key = substr($message,0,$len);

    //    //Extract the encrypted message
    //    $message = substr($message,3);
    //    $ciphertext = substr($message,$len);
    //    $this->response(['cyphertext'=>$ciphertext,'message'=>$message,'key'=>$sym_key],200);
    //    $ciphertext = base64_decode($ciphertext);

    //    // Decrypt the encrypted symmetric key
    //    $rsa->loadKey($asym_key);
    //   // $sym_key = base64_decode($sym_key);
    //    $sym_key = $rsa->decrypt($sym_key);

    //    // Decrypt the message
    //    $rij->setKey($sym_key);
    //    $plaintext = $rij->decrypt($ciphertext);

    //    return $plaintext;
    //}
    //    function AESEncryption($data){
    //$rand= new \phpseclib\Crypt\Random();
    //$cipher = new \phpseclib\Crypt\AES(); // could use AES::MODE_CBC
//// keys are null-padded to the closest valid size
//// longer than the longest key and it's truncated
////$cipher->setKeyLength(128);
//$cipher->setKey('abcdefghijklmnop');
//// the IV defaults to all-NULLs if not explicitly defined
//$cipher->setIV($rand::string($cipher->getBlockLength() >> 3));

//$size = 10 * 1024;
//$plaintext = str_repeat('a', $size);

//echo $cipher->decrypt($cipher->encrypt($plaintext));
//    }


    function getPrivateRsaKey()
    {
        $returnString = file_get_contents('8000.key', FILE_USE_INCLUDE_PATH);
        //  $returnString = str_replace("-----BEGIN PUBLIC KEY-----","",$returnString);
        //  $returnString = str_replace("-----END PUBLIC KEY-----","",$returnString);
        return $returnString;// $this->removenewline($returnString);
    }
    function getPublicRsaKey()
    {
        $returnString = file_get_contents('8000.csr', FILE_USE_INCLUDE_PATH);
      //  $returnString = str_replace("-----BEGIN PUBLIC KEY-----","",$returnString);
      //  $returnString = str_replace("-----END PUBLIC KEY-----","",$returnString);
        return $returnString;// $this->removenewline($returnString);
    }

    function removenewline($string){
        $tempstring = str_replace(array("\r", "\n"), '', $string);
        $tempstring = str_replace(array("\/"), '/', $tempstring);
        return $tempstring;
    }
}
