<?php
/**
 * Ean Daus
 * 3/1/2019
 * database.php
 * A class representing a Database object with several useful methods
 */

/*
CREATE TABLE `edausgre_grc`.`Members` ( `member_id` INT NOT NULL AUTO_INCREMENT ,
`first` VARCHAR(20) NOT NULL , `last` VARCHAR(20) NOT NULL , `age` INT NOT NULL ,
`gender` VARCHAR(10) NOT NULL , `phone` CHAR(10) NOT NULL , `email` VARCHAR(30) NULL ,
`state` VARCHAR(30) NULL , `seeking` VARCHAR(10) NULL , `bio` VARCHAR(500) NULL ,
`premium` TINYINT NOT NULL , `image` VARCHAR(30) NULL , `interests` VARCHAR(250) NULL ,
PRIMARY KEY (`member_id`)) ENGINE = MyISAM;
*/

require "/home/edausgre/config.php";

/**
 * Represents a Database object with methods for adding and retrieving data.
 */
class Database
{
    /**
     * Makes a new connection to the database, returns a PDO object.
     * @return PDO|void
     */
    function connect()
    {
        try {
            //Instantiate a database object
            $dbh = new PDO(DB_DSN, DB_USERNAME,
                DB_PASSWORD);
            //echo "Connected to database!!!";
            return $dbh;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return;
        }
    }

    /**
     * Adds the provided member ovject to the database.
     * @param $member Member The member to be added.
     * @return bool True if the member was inserted correctly, false otherwise.
     */
    function insertMember($member)
    {
        global $dbh;

        //1. define the query
        $sql = "INSERT INTO Members(`first`, `last`, `age`, `gender`, `phone`, `email`, `state`, `seeking`, `bio`, `premium`, `interests`)
            VALUES (:first, :last, :age, :gender, :phone, :email, :state, :seeking, :bio, :premium, :interests)";

        //2. prepare the statement
        $statement = $dbh->prepare($sql);

        //set param values based on member type
        $first = $member->getFirst();
        $last = $member->getLast();
        $age = $member->getAge();
        $gender = $member->getGender();
        $phone = $member->getPhone();
        $email = $member->getEmail();
        $state = $member->getState();
        $seeking = $member->getSeeking();
        $bio = $member->getBio();
        $premium = 0;
        $interests = null;

        if (get_class($member) == 'PremiumMember') {
            $premium = 1;
            $interests = implode(', ', array_merge($member->getInDoorInterests(), $member->getOutDoorInterests()));
        }

        //3. bind parameters
        $statement->bindParam(':first', $first, PDO::PARAM_STR);
        $statement->bindParam(':last', $last, PDO::PARAM_STR);
        $statement->bindParam(':age', $age, PDO::PARAM_STR);
        $statement->bindParam(':gender', $gender, PDO::PARAM_STR);
        $statement->bindParam(':phone', $phone, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':state', $state, PDO::PARAM_STR);
        $statement->bindParam(':seeking', $seeking, PDO::PARAM_STR);
        $statement->bindParam(':bio', $bio, PDO::PARAM_STR);
        $statement->bindParam(':premium', $premium, PDO::PARAM_STR);
        $statement->bindParam(':interests', $interests, PDO::PARAM_STR);

        //4. execute the statement
        $success = $statement->execute();

        //5. return the result
        return $success;
    }

    /**
     * Retrieves all members from the database.
     * @return array An array of members.
     */
    function getMembers()
    {
        global $dbh;

        //1. define the query
        $sql = "SELECT * FROM Members ORDER BY last, first";

        //2. prepare the statement
        $statement = $dbh->prepare($sql);

        //4. execute the statement
        $statement->execute();

        //5. return the result
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        //print_r($result);
        return $result;
    }

    /**
     * Retrieves a single member with the given id.
     * @param $id int The id of the member to be retrieved.
     * @return mixed The member with the given id.
     */
    function getMember($id)
    {
        global $dbh;

        //1. define the query
        $sql = "SELECT * FROM Members where member_id = :id";

        //2. prepare the statement
        $statement = $dbh->prepare($sql);

        //bind params
        $statement->bindParam(':id', $id, PDO::PARAM_STR);

        //4. execute the statement
        $statement->execute();

        //5. return the result
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
}