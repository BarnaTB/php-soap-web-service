<?php

class Db{
    /**Handles all database transactions
     * Creates connection to database when instantiated
     */

    private $servername;
    private $username;
    private $password;

    public function __construct(){
        $this->servername = getenv('SERVER_NAME');
        $this->username = getenv('DB_USERNAME');
        $this->password = getenv('DB_PASSWORD');

        $this->connection = new mysqli($this->servername, $this->username, $this->password);

        if ($this->connection->connect_error){
            die("Error creating database: " . $this->connection->connect_error);
        }

        $this->create_db($this->connection);
        $this->create_members_table($this->connection);
    }

    public function create_db($connection){
        /**Creates a database.
         * @connection is the connection string that's used for all database transactions
         */

        $dbname = getenv('DB_NAME');
        $selected_db = mysqli_select_db($connection, $dbname);

        if (!$selected_db){
            $createdb = "CREATE DATABASE IF NOT EXISTS $dbname";
            if ($this->connection->query($createdb)) {
                echo "Database created successfully!";
            } else {
                echo "Error creating database: " . mysqli_error($connection);
            }
            $connection->close();
        }
    }

    public function create_members_table($connection){
        /**Function to create a table for saving the response information
         * @connection is the connection string used for all database transactions
         */

        $sql = "CREATE TABLE IF NOT EXISTS Members(
            userId INT PRIMARY KEY,
            email VARCHAR(50) NOT NULL,
            name VARCHAR(50) NOT NULL,
            username VARCHAR(50) NOT NULL,
            pin INT NOT NULL,
            password TEXT NOT NULL
        )
        ";
        $query = mysqli_query($connection, $sql);

        if (!$query){
            echo 'Error creating table: ' . mysqli_error($connection);
        }
    }

    public function insert_user($tablename, array $values){
        /**Function to insert a user into the Members table.
         * @connection is a connection string used for all database transactions.
         * @tablename is a string representing the name of the tabel to which the data should be inserted.
         */

        $id = $values['id'];
        $email = $values['email'];
        $name = $values['name'];
        $username = $values['username'];
        $pin = $values['pin'];
        $password = $values['loginPassword'];

        $connection = $this->connection;

        $sql = "INSERT INTO $tablename(userId, email, name, username, pin, password)
        VALUES ($id, '$email', '$name', '$username', $pin, '$password')
        ";

        $query = mysqli_query($connection, $sql);
        
        if ($query){
            echo"<h2>Success!<h2/>";
            echo"<br>";
            echo "<p>{$username} registered successfully!<p/>";
        }else{
            echo 'Error saving user: ' . mysqli_error($connection);
        }
    }
}
?>