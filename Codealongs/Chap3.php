<html>
    <head>
        <meta charset="UTF-8">
        <title>Chapter 3 Php</title>
    </head>
    <body>
        
        
          <?php
         //put the code here
          $mykev = 1;
          while($mykev++ < 5)
          {
              echo "Key".$mykev."<BR>";
          }
          $row = 10;
          $cols = 10;
          echo "<table border = 1>";
          for($tr = 1; $tr <= $row; $tr++)
          {
              echo "<tr>";
              for($td = 1; $td <= $cols; $td++)
              {
                  echo "<td align='center'>".$tr*$td."</td>"; 
              }
              echo "</tr>";
          }
          echo "</table>";
          $myName = 10;
          $num = 10;
          $num .= $myName;
          echo $num;
          
          echo $myName."<br>".$num;
          echo "<br>".++$num;
          
          $x = "y";
          $y = "x";
          
          //test question
          echo "<br>".$$x . "<br>". $y;
          print("<br>"."Kevin"."Hello world");
          printf("Hello world %s",$myName);
          
          //Scalar variable
          $value = (int)true;
          $value = 'Hello world';
          $value = 0755;
          $value = 0xabc;
          echo "<br>".$value."<br>";
          
          $MYName = "Jeeva";
          
          $x = "5";
          $y = "10";
          echo $x + $y."<br>";
          echo gettype($x);
          
          //by ref variable
          
          $x = & $y;
          $y = 100;
          
          echo "<BR>".$x."<br>";
          
          //constant
          const PI = 3.14;
          echo PI;
          
          $myNum = 5;
          
          if ($myNum === 5)
          {
              echo "It is equal";
          }
          elseif ($myNum > 0)
          {
              echo "It is greater than zero";
          }
          else
          {
              echo "It is less than zero";
          }
          echo "<BR> Kevin".$myNum <=> $y."<BR>";
          
          for ($i = 0;$i <= 5;$i++)
          {
            echo $i."<br>";  
          }
           $i = 0;
          do
          {
             
            //  echo $i."<br>";
            echo pow($i,2)."<BR>";
              $i++;
          }while($i < 10);
          
          ?>
        <!--this is short circuit tag--!>
         My name is <?=$myName?>
    </body>
        
  
</html>


<!--* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */-->

