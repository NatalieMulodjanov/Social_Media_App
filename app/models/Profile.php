<?php
namespace app\models; 

class Profile extends \app\core\Model{

    public $profile_id;
    public $user_id;
    public $first_name;
    public $middle_name;
    public $last_name;

    public function __construct(){
        parent::__construct();
    }

    public function setFirst_name($first_name){
		$this->first_name = $first_name;
	}

	public function getFirst_name(){
		return $this->first_name;
	}

	public function setMiddle_name($middle_name){
		$this->middle_name = $middle_name;
	}

	public function getMiddle_name(){
		return $this->middle_name;
	}

    public function setLast_name($last_name){
		$this->last_name = $last_name;
	}

	public function getLast_name(){
		return $this->last_name;
	}
    
    public function create(){
        $SQL = 'INSERT INTO profile (user_id, first_name, middle_name, last_name) VALUES (:user_id, :first_name, :middle_name, :last_name)';
        $STMT = self::$_connection->prepare($SQL);
        $STMT->execute(['user_id' => $this->user_id, 'first_name' => $this->first_name, 'middle_name' => $this->middle_name, 'last_name' => $this->last_name]);
    }

    public function getByUserId($user_id){
        $SQL = 'SELECT * FROM profile WHERE user_id = :user_id';
        $STMT = self::$_connection->prepare($SQL);
        $STMT->execute(['user_id' => $user_id]);
        $STMT->setFetchMode(\PDO::FETCH_CLASS,'app\\models\\Profile');
        return $STMT->fetch();
    }

    public function get($profile_id) {
        $SQL = 'SELECT * FROM profile WHERE profile_id = :profile_id';
        $STMT = self::$_connection->prepare($SQL);
        $STMT->execute(['profile_id' => $profile_id]);
        $STMT->setFetchMode(\PDO::FETCH_CLASS,'app\\models\\Profile');
        return $STMT->fetch();
    }
    public function searchByName($searchTerm){
		$SQL = $SQL = "SELECT * FROM profile WHERE first_name LIKE :searchTerm OR last_name LIKE :searchTerm OR middle_name LIKE :searchTerm";
        $STMT = self::$_connection->prepare($SQL);
        $STMT->execute(['searchTerm' => '%'. $searchTerm. '%']);
        $STMT->setFetchMode(\PDO::FETCH_CLASS, 'app\\models\\Profile');
        return $STMT->fetchAll();
    }

    public function update(){
		$SQL = 'UPDATE `profile` SET `first_name`=:first_name,`middle_name`=:middle_name,`last_name`=:last_name WHERE profile_id = :profile_id';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['first_name'=>$this->first_name,'middle_name'=>$this->middle_name,'last_name'=>$this->last_name,'profile_id'=>$this->profile_id]);
	}
}
