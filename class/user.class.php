<?php
class User{
    public $id;
    public $waka_id;
    public $email;
    public $name;
    public $website;
    public $registered;
    public $updated;
    public $access_token;
    public $refresh_token;
    public $photo;

    private $db;

    private $cookie_salt = 'dinsorsee';
    private $key = 'bRuD5WYw5wd0rdHR9yLlM6wt2vteuiniQBqE70nAuhU=';

    public function __construct() {
        global $wpdb;
        $this->db = $wpdb;
    }

    public function loginChecking(){
        // READ COOKIES
        if(!empty($_COOKIE['login_string']) && empty($_SESSION['login_string']))
            $_SESSION['login_string'] = $_COOKIE['login_string'];

        // Check if all session variables are set
        if(isset($_SESSION['login_string'])){

            $user_id = $this->Decrypt($_SESSION['login_string']);

            $this->get($user_id);

            if(!empty($this->id)){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function get($user_id){
        $this->db->query('SELECT * FROM user WHERE id = :user_id');
        $this->db->bind(':user_id',$user_id);
        $this->db->execute();
        $dataset = $this->db->single();

        $this->id = $dataset['id'];
        $this->waka_id = $dataset['waka_id'];
        $this->email = $dataset['email'];
        $this->name = $dataset['name'];
        $this->website = $dataset['website'];
        $this->access_token = $dataset['access_token'];
        $this->refresh_token = $dataset['refresh_token'];
        $this->updated = $dataset['updated'];
        $this->photo = $dataset['photo'];
    }

    public function register($waka_id,$name,$email,$website,$access_token,$refresh_token,$photo){
        $hasAccountID = $this->hasAccount($waka_id,$email);
        if($hasAccountID == -1){
            $this->db->query('INSERT INTO user(waka_id,name,email,website,registered,access_token,refresh_token,updated,photo) VALUE(:waka_id,:name,:email,:website,:registered,:access_token,:refresh_token,:updated,:photo)');
            $this->db->bind(':waka_id',$waka_id);
            $this->db->bind(':email',$email);
            $this->db->bind(':name',$name);
            $this->db->bind(':website',$website);
            $this->db->bind(':registered', date('Y-m-d H:i:s'));
            $this->db->bind(':updated', date('Y-m-d H:i:s'));
            $this->db->bind(':access_token',$access_token);
            $this->db->bind(':refresh_token',$refresh_token);
            $this->db->bind(':photo',$photo);
            $this->db->execute();
            $user_id = $this->db->lastInsertId();
            return $user_id;
        }else{
            $this->edit($hasAccountID,$name,$email,$website,$photo);
            return $hasAccountID;
        }
    }

    public function edit($user_id,$name,$email,$website,$photo){
        $this->db->query('UPDATE user SET name = :name,email = :email,website = :website,photo = :photo WHERE id = :user_id');
        $this->db->bind(':user_id',$user_id);
        $this->db->bind(':email',$email);
        $this->db->bind(':name',$name);
        $this->db->bind(':website',$website);
        $this->db->bind(':photo',$photo);
        $this->db->execute();
    }

    public function hasAccount($waka_id,$email){
        $this->db->query('SELECT id FROM user WHERE waka_id = :waka_id AND email = :email');
        $this->db->bind(':waka_id',$waka_id);
        $this->db->bind(':email',$email);
        $this->db->execute();
        $dataset = $this->db->single();

        if(!empty($dataset['id']))
            return $dataset['id'];
        else
            return -1;
    }

    public function lostUpate(){
        $this->db->query('SELECT * FROM user WHERE (DATE(updated) != CURDATE() OR updated IS NULL) LIMIT 1');
        $this->db->execute();
        $dataset = $this->db->single();

        return $dataset;
    }

    public function updated($user_id){
        $this->db->query('UPDATE user SET updated = :today WHERE id = :user_id');
        $this->db->bind(':user_id',$user_id);
        $this->db->bind(':today', date('Y-m-d H:i:s'));
        $this->db->execute();
    }

    public function Encrypt($data){
        $key = $this->key;
        $password = $this->cookie_salt;
        $encryption_key = base64_decode($key.$password);
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
        return base64_encode($encrypted . '::' . $iv);
    }
    public function Decrypt($data){
        $key = $this->key;
        $password = $this->cookie_salt;
        $encryption_key = base64_decode($key.$password);
        list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
    }
}
?>