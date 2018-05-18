<?php
/**
 * Created by PhpStorm.
 * User: mzikl
 * Date: 12.5.2018
 * Time: 13:53
 */

include "ServiceUser.php";

class ServiceTeam
{

    /*
     * Function will add new team into table teams.
     * All users in team will be updated.
     * Name must be unique so use function isUsed before.
     * arguments: db connection, name of team, array of ID of users
     */
    function addTeam($db, $nazov, $listOfUsersID)
    {

        $sql = "INSERT INTO teams (nazov) VALUES ('" . $nazov . "')";

        $stmt = $db->prepare($sql);

        $stmt->execute();

        $row = getTeamID($db, $nazov);

        foreach ($listOfUsersID as $userID) {
            updateUsersTeam($db, $userID, $row["id"]);
        }
    }

    /*
     * Function will update name of team and users in team by ID of team.
     * arguments: db connection, ID of team, Name of team, array of User ID
     */
    function updateTeam($db, $teamID, $nazov, $listOfUsersID)
    {
        $sql = "UPDATE teams SET nazov='" . $nazov . "' WHERE id='" . $teamID . "'";

        $stmt = $db->prepare($sql);

        $stmt->execute();

        foreach ($listOfUsersID as $userID) {
            updateUsersTeam($db, $userID, $teamID);
        }
    }

    /*
     * Function will return Team ID based on name of team
     * arguments: db connection, name of team
     * return value: ID of team.
     * DONT USE OUTSIDE OF THIS SERVICE!
     */
    function getTeamID($db, $nazov)
    {
        $sql = "SELECT id FROM teams WHERE nazov='" . $nazov . "'";

        $stmt = $db->prepare($sql);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row["id"];
    }

    /*
     * Function will return all teams in table teams.
     * arguments: db connection
     * return value: array of arrays ($result[index][id/nazov])
     */
    function getAllTeams($db)
    {
        $sql = "SELECT * FROM teams";

        $stmt = $db->prepare($sql);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    /*
     * Function will check if Team name already exist in teams table.
     * If it exist return is TRUE
     * If doesnt return FALSE
     */
    function isUsed($db, $nazov)
    {
        $sql = "SELECT * FROM teams WHERE nazov='" . $nazov . "'";

        $stmt = $db->prepare($sql);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row == false) {
            return false;
        } else {
            return true;
        }
    }

    /*
     * Function will detele team from teams table based on team ID
     * arguments: db connection, ID of team
     */
    function deleteTeam($db, $id)
    {
        $sql = "DELETE FROM teams WHERE id='" . $id . "'";

        $stmt = $db->prepare($sql);

        $stmt->execute();
    }
}