<?php
		function secure_data($data){
			$data = trim($data);
	        $data = stripslashes($data);
	        $data = htmlspecialchars($data);
	
	        return $data;
		}

       function hash_password($password){
			return password_hash($password, PASSWORD_DEFAULT);
		}

        function connectionDB(){
            $host = 'localhost';
            $dbName = 'oswifts';
            $user = 'root';
            $pass = '';
            $charset = 'utf8mb4';
            $hostDB = 'mysql:host='.$host.';dbname='.$dbName.';'.'charset='.$charset.';';
    
            try{
                $connection = new PDO($hostDB,$user,$pass);
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
                return $connection;
            } catch(PDOException $e){
                die('ERROR: '.$e->getMessage());
            }
        }

?>