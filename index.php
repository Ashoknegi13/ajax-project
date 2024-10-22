
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Ajax insert data </title>
	<style>
		body{
			font-family: arial;
		}
		#main{
			background: white;
			height: 200px;
		}
		#successmessage{
			background: #DEF1D8;
			color: green;
			padding:10px;
			margin: 10px;
		 	display: none;
		 	position: absolute;
		 	right: 15px;
		 	top: 15px;
		}
	#errormessage{
			background: #EFDCDD;
			color: red;
			padding:10px;
			margin: 10px;
		 	display: none;
		 	position: absolute;
		 	right: 15px; 
		 	top: 15px;
		}
		.delete-btn{
			cursor: pointer;
		}
		#modal{
		 background: rgba(0, 0, 0, 0.7);
		 position: fixed;
		 left: 0;
		 top: 0;
		width: 100%;
		height: 100%;
		z-index: 100;
		display: none;
		}
		#modal-form{
			background: #fff;
			width:30%;
			position: relative;
			tp:20%;
			left: calc(50% - 15%);
			padding: 15px;
			border-radius: 4px;
		}
		#modal-form h2{
  			margin: 0 0 15px;
  			padding-bottom: 10px ;
  			border-bottom: 1px solid black;
		}
		#close-btn{
			background: red;
			color: white;
			width: 30px;
			height: 30px;
			line-height: 30px;
			text-align: center;
			border-radius: 50px;
			position: absolute;
			top: -15px;
			right: -15px;
			cursor: pointer;
		}
		
	</style>
	
</head>
<body>
		<table id="main" border="0" cellspacing="0" align="center">
			<tr>
				<td id="header" style=" padding: 0px; background: pink;">
					<h1 style="margin-left: 100px;">Add Record with PHP and AJAX</h1>
					<div id="search-bar" style="margin-left: 150px;">
						<label style="font-size: 25px;">Search :</label>
						<input type="Search" id="search" autocomplete="off">
					</div>
				</td>
			</tr>
			<tr>
				<td  id="table-form" style="background:tan; padding: 20px;">
					<form id="addform"  autocomplete="off">
					  first Name :	<input type="text" id="fname" >   	
					  Last Name : <input type="text" id="lname"  >
					  <input type="button" id="save-btn" value="save">			   	
					</form>
				</td>
			</tr>
			<tr>
				<td id="table-data">	
				</td>
			</tr>
		</table>

  	


		<div id="errormessage"></div>
		<div id="successmessage"></div>
		<div id="modal">
			<div id="modal-form">
				<h2>Edit From</h2>
				<table cellpadding="10px" width="100%">

				</table>
				<div id="close-btn" style="margin-top:20px" >X</div>
			</div>
		</div>

  <script  src="js/jquery.js"></script>
  <script>
  	$(document).ready(function(){
        	
  
  			// STEP 1 <<<<<----------------- Retrive data from database ----------------->>>>>>
        	function loadTable(page){
        		$.ajax({
        			url : "ajax-load.php",
        			type : "POST",
        			data : {page_no:page},
        			success : function(data){
        				$('#table-data').html(data);
        			}
        		});
        	}
        	loadTable();

        	// STEP 9 Pagination Code --------------------------------->>
        	$(document).on("click","#pagination a",function(e){
        		e.preventDefault();
        		var page_id = $(this).attr("id");
        		loadTable(page_id);

        	});


        // STEP 2 <<<<<----------------- Insert data Into database ----------------->>>>>>
        	$('#save-btn').on("click",function(e){
        		e.preventDefault();
        		var fname = $("#fname").val();
        		var lname = $("#lname").val();
        		if(fname =="" || lname==""){
        			$('#errormessage').html("All field are required").slideDown('slow');
        			$('#successmessage').slideUp();
        		}else{

        				$.ajax({
        						url : "ajax-insert.php",
        						type : "POST",
        						data : {first_name:fname,last_name:lname},
        						success : function(data){
        					    				 if(data == 1){
        		             						loadTable();
        		             				$('#addform').trigger("reset");						
        						$('#successmessage').html("Successfully add data").slideDown('slow');
        						$('#errormessage').slideUp();
        										}else{					
        		               $('#errormessage').html("Can't save record").slideDown('slow');
        						$('#successmessage').slideUp();
				        							}
        									}
        						});
        			}
        		
        	});

       // STEP 3 <<<<<----------------- Delete data from database ----------------->>>>>>
  		$(document).on("click",".delete-btn",function(){
  			if(confirm("Do you really want to delete this data")){
  			var studentid =$(this).data("id");
  			var element = this;

  			$.ajax({
  				url : "ajax-delete.php",
  				type : "POST",
  				data : {id:studentid},
  				success : function(data){
  					if(data==1){
  						loadTable();
  						$(element).closest("tr").fadeOut();
  						 $("#successmessage").html("Data is Delete").slideDown("slow");
  						$("#errormessage").slideUp();
  					}else{
  						$("#errormessage").html("Data Can't Delete").slideDown("slow");
  						$("#successmessage").slideUp();
  					}
  				}
  			});
  		  }
  		});


  	   // STEP 4 <<<<<----------------- Update data into database ----------------->>>>>>
  	
  		// STEP 5 show model box--------------------------------->>
  		$(document).on("click",".edit-btn",function(){
  			$('#modal').slideDown('slow');
			var studenteid = $(this).data("eid");
			
			// STEP 7 showing data on input field where id == student id --------------------------------->> 
			$.ajax({
				url : "load-update-form.php",
				type : "POST",
				data : {eid : studenteid},
				success : function(data){
			       $("#modal-form table").html(data);
				}
			});
  		});
  		
  		// STEP 6 hide model box--------------------------------->>
  		$('#close-btn').on("click",function(){
  			$("#modal").slideUp('slow');
  		});

  		// STEP 8 save update form--------------------------------->>
  		$(document).on("click","#update-btn",function(){
  			var stuid = $("#edit-id").val();
  			var stufname = $("#edit-fname").val();
  			var stulname = $("#edit-lname").val();
  		

  		// STEP 9 pass these value for updating in database--------------------------------->>
  			 $.ajax({
  			 	url : "ajax-update-form.php",
  			 	type : "POST",
  			 	data : {uid : stuid , ufname : stufname , ulname : stulname},
  			 	success : function(data){
  			 		  if(data==1){
  			 		$("#modal").slideUp('slow');
  			 		loadTable(); 
  			 	}else{
  			 		alert("data not update");
  			 	 }
  			   }
  			 });
  		});


  		// STEP 9  Live Search--------------------------------->>
  		$('#search').on("keyup",function(){
  			var search_term = $(this).val();

  			$.ajax({
  					url : "ajax-live-search.php",
  					type : "POST",
  					data : {search : search_term},
  					success : function(data){
  							$("#table-data").html(data);
  					}
  			});
  		});


  		  		
  	


  	});
  </script>

</body>
</html>
