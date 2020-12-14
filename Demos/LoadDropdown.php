<html>
<head>
<title>Load Dropdown Demo</title>
<!-- I was going to comment this to explain how to turn it dynamic by using PHP, 							-->
<!-- but I get asked the question so often by 2nd year students "Do we still have to comment *our* code?" 	-->
<!-- that I thought I would give you the answer like this...												-->

<!-- "It's obvious to me how I would do it, so I guess I don't need to comment it."							-->
<!-- It's the answer I usually get!																			-->

<script language="JavaScript">
	
	function setDeptCatOptions(DeptChosen) {
			 
			 var catbox = document.frmDeptCat.optCat;
 
 			 catbox.options.length = 0;
			 
			 switch (DeptChosen) {
			 
			 		default  :
			 		case " " :
  			 			 catbox.options[catbox.options.length] = new Option('--Category--',' ');
 						 break; 			
			 
			 		case "Dept.X" : 
  			 			 catbox.options[catbox.options.length] = new Option('Cat.A','DeptX,CatA');
  						 catbox.options[catbox.options.length] = new Option('Cat.B','DeptX,CatB');
  						 catbox.options[catbox.options.length] = new Option('Cat.C','DeptX,CatC');
  						 catbox.options[catbox.options.length] = new Option('Cat.D','DeptX,CatD');
  						 catbox.options[catbox.options.length] = new Option('Cat.E','DeptX,CatE');
						 break;
			
					case "Dept.Y" :
  			   			 catbox.options[catbox.options.length] = new Option('Cat.F','DeptY,CatF');
  			   			 catbox.options[catbox.options.length] = new Option('Cat.G','DeptY,CatG');
			   			 break;
			
					case "Dept.Z" :
  			   			 catbox.options[catbox.options.length] = new Option('Cat.H','DeptZ,CatH');
  			   			 catbox.options[catbox.options.length] = new Option('Cat.I','DeptZ,CatI');
  			   			 catbox.options[catbox.options.length] = new Option('Cat.J','DeptZ,CatJ');
			   			 break;
			}

	}
	
</script>
</head>

<body>


<form name="frmDeptCat">

<select name="optDept" size="1" onchange="setDeptCatOptions(document.frmDeptCat.optDept.options[document.frmDeptCat.optDept.selectedIndex].value);">
		<option value=" " selected="selected">--Department--</option>
		<option value="Dept.X">Dept.X</option>
		<option value="Dept.Y">Dept.Y</option>
		<option value="Dept.Z">Dept.Z</option>
</select>

<select name="optCat" size="1">
		<option value=" " selected="selected">--Category--</option>
</select>

<input type="button" name="go" value="Value Selected" onclick="alert(document.frmDeptCat.optCat.options[document.frmDeptCat.optCat.selectedIndex].value);">
</form>


</body>
</html>
