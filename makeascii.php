<?php

$showResult = isset($_REQUEST['q']);

if ($showResult) {

  $q = $_REQUEST['q'];

  // mb_internal_encoding("UTF-8");

  $lines = explode("\n", $q);


  $alphabet = array(
    "a" => array(
      "▄▀▄",
      "█▀█",
      "▀░▀"
    ),
    "b" => array(
      "█▀▄",
      "█▀▄",
      "▀▀░"
    ),
    "c" => array(
      "█▀▀",
      "█░░",
      "▀▀▀"
    ),
    "d" => array(
      "█▀▄",
      "█░█",
      "▀▀░"
    ),
    "e" => array(
      "█▀▀",
      "█▀▀",
      "▀▀▀"
    ),
    "f" => array(
      "█▀▀",
      "█▀▀",
      "▀░░"
    ),
    "g" => array(
      "█▀▀░",
      "█░▀█",
      "▀▀▀░"
    ),
    "h" => array(
      "█░░█",
      "█▀▀█",
      "▀░░▀"
    ),
    "i" => array(
      "▀█▀",
      "░█░",
      "▀▀▀"
    ),
    "j" => array(
      "▀█▀",
      "░█░",
      "▀▀░"
    ),
    "k" => array(
      "█░█",
      "█▀▄",
      "▀░▀"
    ),
    "l" => array(
      "█░░",
      "█░░",
      "▀▀▀"
    ),
    "m" => array(
      "█▄░▄█",
      "█░▀░█",
      "▀░░░▀"
    ),
    "n" => array(
      "█▄░█",
      "█░▀█",
      "▀░░▀"
    ),
    "o" => array(
      "█▀▀█",
      "█░░█",
      "▀▀▀▀"
    ),
    "p" => array(
      "█▀█",
      "█▀▀",
      "▀░░"
    ),
    "q" => array(
      "█▀█░",
      "█░█░",
      "▀▀▀▄"
    ),
    "r" => array(
      "█▀█",
      "██▀",
      "▀░▀"
    ),
    "s" => array(
      "█▀▀",
      "▀▀█",
      "▀▀▀"
    ),
    "t" => array(
      "▀█▀",
      "░█░",
      "░▀░"
    ),
    "u" => array(
      "█░░█",
      "█░░█",
      "▀▀▀▀"
    ),
    "v" => array(
      "█░░░█",
      "░█░█░",
      "░░▀░░"
    ),
    "w" => array(
      "█░░░█",
      "█░▄░█",
      "▀▀░▀▀"
    ),
    "x" => array(
      "█░█",
      "▄▀▄",
      "▀░▀"
    ),
    "y" => array(
      "▀▄░▄▀",
      "░░█░░",
      "░░▀░░"
    ),
    "z" => array(
      "▀▀█",
      "▄▀░",
      "▀▀▀"
    ),
    "0" => array(
      "█▀█",
      "█░█",
      "▀▀▀"
    ),
    "1" => array(
      "▄█░",
      "░█░",
      "▀▀▀"
    ),
    "2" => array(
      "▀▀█",
      "█▀▀",
      "▀▀▀"
    ),
    "3" => array(
      "▀▀█",
      "▀▀█",
      "▀▀▀"
    ),
    "4" => array(
      "█░░█",
      "░▀▀█",
      "░░░▀"
    ),
    "5" => array(
      "█▀▀",
      "▀▀█",
      "▀▀░"
    ),
    "6" => array(
      "█▀▀",
      "█▀█",
      "▀▀▀"
    ),
    "7" => array(
      "▀▀█",
      "░░█",
      "░░▀"
    ),
    "8" => array(
      "█▀█",
      "█▀█",
      "▀▀▀"
    ),
    "9" => array(
      "█▀█",
      "▀▀█",
      "░░▀"
    ),
    "." => array(
      "░",
      "░",
      "▀"
    ),
    "'" => array(
      "█",
      "░",
      "░"
    ),
    ":" => array(
      "▄",
      "▄",
      "░"
    ),
    "_" => array(
      "░░░",
      "░░░",
      "▀▀▀"
    ),
    "-" => array(
      "░░░",
      "▀▀▀",
      "░░░"
    ),
    "+" => array(
      "░▄░",
      "▀█▀",
      "░░░"
    ),
    "=" => array(
      "▄▄▄",
      "▄▄▄",
      "░░░"
    ),
    "/" => array(
      "░░█",
      "▄▀░",
      "▀░░"
    ),
    "\\" => array(
      "█░░",
      "░▀▄",
      "░░▀"
    ),
    "|" => array(
      "█",
      "█",
      "█"
    ),
    "<" => array(
      "░▄▀",
      "▀▄░",
      "░░▀"
    ),
    ">" => array(
      "▀▄░",
      "░▄▀",
      "▀░░"
    ),
    "*" => array(
      "▄░█░▄",
      "▄▀█▀▄",
      "░░▀░░"
    ),
    "!" => array(
      "█",
      "▀",
      "▀"
    ),
    "?" => array(
      "▀▀█",
      "░▀▀",
      "░▀░"
    ),
    "$" => array(
      "▄█▀",
      "▀██",
      "▀▀░"
    ),
    "#" => array(
      "▄█▄█▄",
      "▄█▄█▄",
      "░▀░▀░"
    ),
    "~" => array(
      "░▄░▄",
      "▀░▀░",
      "░░░░"
    ),
    "^" => array(
      "▄▀▄",
      "░░░",
      "░░░"
    ),
    "(" => array(
      "▄▀",
      "█░",
      "░▀"
    ),
    ")" => array(
      "▀▄",
      "░█",
      "▀░"
    ),
    "[" => array(
      "█▀",
      "█░",
      "▀▀"
    ),
    "]" => array(
      "▀█",
      "░█",
      "▀▀"
    ),
    " " => array(
      "░",
      "░",
      "░"
    )

  );

  $specialChars = array(
    "%" => array(
      "▀░█",
      "▄▀░",
      "▀░▀"
    ),
    "t" => array(
      "░░█░░",
      "░███░",
      "▀▀▀▀▀"
    ),
    "b" => array(
      "███",
      "███",
      "▀▀▀"
    ),
    "h" => array(
      "▄█▄█▄",
      "▀███▀",
      "░░▀░░"
    ),
    "*" => array(
      "▄▄█▄▄",
      "░███░",
      "░▀░▀░"
    ),
    "l" => array(
      "░▄▀░░░",
      "▀█▀▀▀▀",
      "░░▀░░░"
    ),
    "r" => array(
      "░░░▀▄░",
      "▀▀▀▀█▀",
      "░░░▀░░"
    )
  );

  $kerning = "░";


  $output = array();

  for ($i = 0; $i < count($lines); $i++) {

    $outputLine = array("","","");

    $chars = str_split($lines[$i]);
    for ($j = 0; $j < count($chars); $j++) {
      $char = $chars[$j];
      if ($char == "%") {
        if (!($j+1 < count($chars))) continue;
        $j++;
        $asciiChar = $specialChars[$chars[$j]];
      } else {
        $asciiChar = $alphabet[strtolower($char)];
      }

      $outputLine[0] .= $asciiChar[0];
      $outputLine[1] .= $asciiChar[1];
      $outputLine[2] .= $asciiChar[2];

      if ($j+1 < count($chars)) {
        $outputLine[0] .= $kerning;
        $outputLine[1] .= $kerning;
        $outputLine[2] .= $kerning;
      }
    }
    $lineLength = strlen(utf8_decode($outputLine[0]));

    for ($j = 0; $j < 26-$lineLength; $j++) {
      if ($j % 2 == 1) {
        $outputLine[0] = $outputLine[0] . $kerning;
        $outputLine[1] = $outputLine[1] . $kerning;
        $outputLine[2] = $outputLine[2] . $kerning;
      } else {
        $outputLine[0] = $kerning . $outputLine[0];
        $outputLine[1] = $kerning . $outputLine[1];
        $outputLine[2] = $kerning . $outputLine[2];
      }
    }

    $output[$i*3] = $outputLine[0];
    $output[$i*3+1] = $outputLine[1];
    $output[$i*3+2] = $outputLine[2];
  }
}

header('Content-Type: text/html; charset=utf-8');

?>


<html>
<body>
  <h1>Twitch Chat ASCII Generator</h1>
  <p>Enter some text and this site will make a nice obnoxious ASCII out of it. Currently supports all letters, numbers, most common punctuation, and a few special characters</p>
  <p><strong>YO!</strong> It'll probably look super broken if you put too much text on a single line. Put like no more than 8 letters per line.</p>
  <p>There are some special characters that can be inserted by entering a code that begins with a percent sign (%). Here is a table of them:</p>

  <table>
    <tr>
      <th>Code</th>
      <th>Character</th>
    </tr>
    <tr>
      <td>%%</td>
      <td>percent sign (%)</td>
    </tr>
    <tr>
      <td>%t</td>
      <td>triangle</td>
    </tr>
    <tr>
      <td>%b</td>
      <td>solid box</td>
    </tr>
    <tr>
      <td>%h</td>
      <td>heart</td>
    </tr>
    <tr>
      <td>%*</td>
      <td>star</td>
    </tr>
    <tr>
      <td>%l</td>
      <td>left arrow</td>
    </tr>
    <tr>
      <td>%r</td>
      <td>right arrow</td>
    </tr>
  </table>

  <br><br>

  <form action="makeascii.php" method="post">
    <textarea name="q" rows="8" cols="16"><?php if ($showResult) { echo $q; } ?></textarea>
    <p><input type="submit"></p>
  </form>
<?php

if ($showResult) {

  echo "<h2>Preview:</h2><div style='max-width:320px; overflow-x:hidden; font-size: 13.3333301544189px; border: 1px solid black; padding: 4px'>";

  for ($i = 0; $i < count($output); $i++) {
    echo $output[$i] . " \n<br>";
  }


  echo "</div><h2>Copy this:</h2><textarea style='font-family:sans-serif; width:500px; height:150px'>";

  for ($i = 0; $i < count($output); $i++) {
    echo $output[$i] . " ";
  }

  echo "</textarea>";
}

echo "</body></html>";

?>