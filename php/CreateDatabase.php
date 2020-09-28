<?php


// using PHP script to create Database instead of user interface of PHP
class CreateDatabase
{
    public $servername;
    public $username;
    public $password;
    public $databasename;
    public $tablename;
    public $connection;

    // class constructor
    public function __construct(
        $databasename = "Newdatabase",
        $tablename = "Productdatabase",
        $servername = "localhost",
        $username = "root",
        $password = ""
    )
    {
        $this->databasename = $databasename;
        $this->tablename = $tablename;
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;

        // create connection with mySQL function
        $this->connection = mysqli_connect($servername, $username, $password);

        // check connection
        if(!$this->connection){
            die("Connection failed: ".mysqli_connect_error());
        }

        //query >> to create a new Database
        $sql = "CREATE DATABASE IF NOT EXISTS $databasename";

        //execute query
        if(mysqli_query($this->connection, $sql)){
            $this->connection = mysqli_connect($servername, $username, $password, $databasename);

            //sql to create new table
            $sql="
                CREATE TABLE IF NOT EXISTS $tablename
                (id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
                 product_name VARCHAR(25) NOT NULL,
                 product_price FLOAT,
                 product_image VARCHAR(100)
                );";

            if(!mysqli_query($this->connection, $sql)){
                echo "Error creating table: ".mysqli_error($this->connection);
            }


        } else {
            return false;
        }
    }
    //get product from database
    public function getData(){
        $sql = "SELECT * FROM $this->tablename";

        $result = mysqli_query($this->connection, $sql);

        // rows > 0, success to access to data
        if(mysqli_num_rows($result) > 0){
            return $result;
        }
    }
}