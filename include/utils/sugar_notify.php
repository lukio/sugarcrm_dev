<?php

/*
 * Set a message which reflects the status of the performed operation.
 * 
 * If the function is called with no arguments,
 * this function returns all set messages without clearing them.
 * 
 * Parametros
 * 
 * $message The message to be displayed to the user.i
 * For consistency with other messages, it should begin with a capital letter and end with a period.
 * 
 * $type The type of the message. One of the following values are possible:
 * - 'info'
 * - 'success'
 * - 'alert'
 * - 'error'
 * - 'working'
 * 
 * $repeat If this is FALSE and the message is already set, then the message won't be repeated.
 * 
*/
function sugar_set_notify($notify = NULL, $type = 'info', $repeat = TRUE)
{
    if ($notify) 
    {
        if (!isset($_SESSION['notify'][$type])) 
        {
            $_SESSION['notify'][$type] = array();
        }

        if ($repeat || !in_array($notify, $_SESSION['notify'][$type])) 
        {
            $_SESSION['notify'][$type][] = $notify;
        }
    }

    // notifys not set when DB connection fails.
    return isset($_SESSION['notify']) ? $_SESSION['notify'] : NULL;
}

/*
 * Return all notifys that have been set.
 * Parameters
 * 
 * $type (optional) Only return notifys of this type.
 * 
 * $clear_queue (optional) Set to FALSE if you do not want to clear the notifys queue
 * 
 * Return value
 * 
 * An associative array, the key is the notify type,
 * the value an array of notifys. If the $type parameter is passed,
 * you get only that type, or an empty array if there are no such notifys. 
 * If $type is not passed, all notify types are returned,
 * or an empty array if none exist.
*/
function sugar_get_notify($type = NULL, $clear_queue = TRUE) 
{
    if ($notify = sugar_set_notify()) 
    {
        if ($type) 
        {
            if ($clear_queue) 
            {
                unset($_SESSION['notify'][$type]);
            }
            if (isset($notify[$type])) 
            {
                return array($type => $notify[$type]);
            }
        }
        else 
        {
            if ($clear_queue) 
            {
                unset($_SESSION['notify']);
            }
            return $notify;
        }
    }
    return array();
}

function sugar_get_notify_list ()
{
    $msg = sugar_get_notify();
    $return_string = "";
    foreach ($msg as $tipo => $ss)
    {
        foreach ($ss as $mensaje)
        {
            $return_string .= "<div class='gcoop_$tipo mensajes'>";
            $return_string .= "$mensaje <br />";
            $return_string .= "</div>";
        }
        unset($mensaje);
    }
    unset($ss);

    return $return_string;
}
?>
