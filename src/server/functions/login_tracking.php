<?php

include_once 'db_connection.php';
include_once 'user_management.php';

class Login_tracking
{
    /**
     * Possible Return Values:
     * - UPDATED
     * - USER_DOES_NOT_EXIST
     * - NOT_UPDATED
     */
    public static function incrementLoginCount($USER_ID)
    {
        if (user_management::validateUserID($USER_ID) == "USER_DOES_NOT_EXIST") {
            return "USER_DOES_NOT_EXIST";
        }
        self::getCountForCurrentMonth($USER_ID); // If no Count Record Exists , adds Default 0.
        $query = "UPDATE LOGIN_COUNT SET LOGIN_COUNT = LOGIN_COUNT + 1 WHERE USER_ID = ? AND MONTH = ? AND YEAR = ?";
        $currentMonth = (int)date('n'); // Current month as integer
        $currentYear = (int)date('Y'); // Current year as integer
        $resp  = executePreparedQuery($query, array('iii', $USER_ID, $currentMonth, $currentYear));
        if ($resp[0]) {
            return "UPDATED";
        }
        return "NOT_UPDATED";

        return "COULD_NOT_EXECUTE_QUERY";
    }
    /**
     * Possible Return Values:
     * - LOGIN_COUNT
     * - COULD_NOT_FIND_RECORD
     */
    /*
    public static function getCountForCurrentMonth($USER_ID)
    {
        $query = "SELECT LOGIN_COUNT FROM LOGIN_COUNT WHERE USER_ID = ? AND MONTH = ? AND YEAR = ?";
        $currentMonth = (int)date('m'); // Current month as integer
        $currentYear = (int)date('Y'); // Current year as integer
        $resp  = executePreparedQuery($query, array('iii', $USER_ID, $currentMonth, $currentYear));
        if ($resp[0]) {
            try {
                return (int) $resp[1]['LOGIN_COUNT'];
            } catch (Exception $e) {
                self::AddDefaultForCurrentMonth($USER_ID);
                return self::getCountForCurrentMonth($USER_ID);
            }
        }
        return "COULD_NOT_FIND_RECORD";
    }
    */

    public static function getCountForCurrentMonth($USER_ID)
    {
        $query = "SELECT LOGIN_COUNT FROM LOGIN_COUNT WHERE USER_ID = ? AND MONTH = ? AND YEAR = ?";
        $currentMonth = (int)date('m'); // Current month as integer
        $currentYear = (int)date('Y'); // Current year as integer
        try{
            $resp  = executePreparedQuery($query, array('iii', $USER_ID, $currentMonth, $currentYear));
            if ($resp[0]){
                //if the query was successful - the user already has data in the login_count table 
                if ($resp[1]=="NO_DATA_RETURNED"){
                    //if the query went off, but there were no results: ie, user ID is NOT in login_count table
                    $addedDefault = self::AddDefaultForCurrentMonth($USER_ID);
                    return $addedDefault;
                }
                //return the number of logins this month
                return $resp[1]['LOGIN_COUNT'];
            }
            else{
                return "STATEMENT_DID_NOT_EXECUTE";
            }
        } catch (Exception $e) {
            echo "Error occurred querying database for login count";
            echo $e->getMessage();
        }
    }


    /**
     * Possible Return Values:
     * - USER_DOES_NOT_EXIST
     * - ADDED
     * - NOT_ADDED
     */
    public static function AddDefaultForCurrentMonth($USER_ID)
    {
        if (user_management::validateUserID($USER_ID) == "USER_DOES_NOT_EXIST") {
            return "USER_DOES_NOT_EXIST";
        }
        $query = "INSERT INTO LOGIN_COUNT (USER_ID,LOGIN_COUNT,MONTH,YEAR) VALUES (?,0,?,?)";
        $currentMonth = (int)date('m'); // Current month as integer
        $currentYear = (int)date('Y'); // Current year as integer
        $resp  = executePreparedQuery($query, array('iii', $USER_ID, $currentMonth, $currentYear));
        if ($resp[0]) {
            return "ADDED";
        } else {
            return "NOT_ADDED";
        }
        return "NOT_ADDED";
    }
}
