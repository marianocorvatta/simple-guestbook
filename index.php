<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <title>Guest Book</title>
 <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>
<body>

  <h1>Awesome Guestbook</h1>

  <h2>Sign our guest book to remember your visit...</h2>

  <?php

  if (isset($_GET['action'])) {
    if ((file_exists("Guestbook/messages.txt")) && (filesize("Guestbook/messages.txt") != 0)) {
      $MessageArray = file("Guestbook/messages.txt");
      switch ($_GET['action']) {
      case 'Delete Message':
        if (isset($_GET['message'])) {
          $Index = $_GET['message'];
          unset($MessageArray[$Index]);
          $MessageArray = array_values($MessageArray);
        }
        break;
      case 'Remove Duplicates':
        $MessageArray = array_unique($MessageArray);
        $MessageArray = array_values($MessageArray);
        break;
      case 'Sort Ascending':
        sort($MessageArray);
        break;
      case 'Sort Descending':
        rsort($MessageArray);
        break;
  } 

  if (count($MessageArray)>0) {
    $NewMessages = implode($MessageArray);
    $MessageStore = fopen("Guestbook/messages.txt", "wb");
    if ($MessageStore === false)
      echo "There was an error updating the message file\n";
    else {
      fwrite($MessageStore, $NewMessages);
      fclose($MessageStore);
    }
    } else
      unlink("Guestbook/messages.txt");   
    }
  }  

  if ((!file_exists("Guestbook/messages.txt")) || (filesize("Guestbook/messages.txt") == 0))
    echo "<p>There are no entries logged.</p>\n";
  else {
    $MessageArray = file("Guestbook/messages.txt");
    echo "<p>This is the list of previous visitors:</p>";
    echo "<table style=\"background-color:lightgray\" border=\"1\" width=\"100%\">\n";

    $count = count($MessageArray);

    $Index = 1;

    for ($i = 0; $i < $count; ++$i) {
      $CurrMsg = explode("~", $MessageArray[$i]);
      // add both values to array:
      $KeyMessageArray[] = array('name' => $CurrMsg[0], 'email' => $CurrMsg[1],);
    }

    foreach($KeyMessageArray as $data) { 
      # echo 'name is ' . $data['name'] . ', email is ' . $data['email'] . "<br />"; 
      echo "<tr>\n";
      echo "<td width=\"5%\" style=\"text-align:center\"><span style=\"font-weight:bold\">" . $Index . "</span></td>\n";
      echo "<td width=\"85%\"><span style=\"font-weight:bold\">Name:</span> " . $data['name'] . "<br />";
      echo "<span style=\"font-weight:bold\">Email:</span> " . $data['email'] . "<br />";
      echo "<td width=\"10%\" style=\"text-align:center\">" . "<a href='index.php?" . "action=Delete%20Message&" . 
          "message=" . ($Index -1) . "'>Delete this entry</a>" . "</td>\n";
      echo "</tr>\n"; 
      ++$Index; 
      next($KeyMessageArray);
    }
    echo "</table>\n";
  }
?>

<p>
  <a href="sign-book.php">Sign here ...</a><br /><br />
  *| <a href="index.php?action=Sort%20Ascending">Sort guests A-Z</a> *|*
  <a href="index.php?action=Sort%20Descending">Sort guests Z-A</a> *|*
  <a href="index.php?action=Remove%20Duplicates">Remove duplicate visitors</a> |*
</p>   

</body>
</html>
