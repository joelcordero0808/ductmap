<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
	label {
		font-weight:bolder;
	}
</style>
    
<!-- Bootstrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous" defer></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous" defer></script>
<script type="text/javascript" src="js/typeahead.js"></script>

<script type="text/javascript" src="js/apps.js"></script>


<!-- JQ confirm -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<!-- JQ confirm -->


</head>
<body>

<div class="container" style="margin-top:20px;">
    <form>
		<div class="form row">
			<div class="form-group col">
			   <label for="txtfrommh">From</label>
			   <input type="text" class="form-control"  id="txtfrommh" name="txtfrommh" placeholder="Point A">
			</div>
			<div class="form-group col">
			   <label for="txttomh">To</label>
			   <input type="text" class="form-control"  id="txttomh" name="txttomh" placeholder="Point B">
			</div>
			<div class="form-group col">
			   <label for="txtdiameter">Diameter</label>
			   <input type="text" class="form-control"  id="txtdiameter" name="txtdiameter" placeholder="Duct diameter (e.g 100mm)">
			</div>
			
		</div>

	
		<div class="form row">
		   <div class="form-group col">
              <label for="cbofromloc">From location</label>
                 <select class="form-control" id="cbofromloc" name="cbofromloc">
                    <option>North</option>
                    <option>East</option>
                    <option>West</option>
                    <option>South</option>
                 </select>
			</div>
			
			<div class="form-group col">
              <label for="cbotoloc">To location</label>
                 <select class="form-control" id="cbotoloc" name="cbotoloc">
                    <option>North</option>
                    <option>East</option>
                    <option>West</option>
                    <option>South</option>
                 </select>
            </div>
			
			<div class="form-group col">
			   <label for="txtductno">No. of duct</label>
			   <input type="text" class="form-control"  id="txtductno" name="txtductno" placeholder="No. of duct">
			</div>
		</div>


		

	</form>

	
	<div class="row">
			<div class="col">
			<button type="button" class="btn btn-secondary float-right" id="btnpreview" style="margin:2px;">Preview</button>
			<button type="button" class="btn btn-primary float-right" id="btnsave" style="margin:2px;">Save</button>
			</div>
		</div>

</div>


</body>


<script type="text/javascript">
	$(function() {
		
		$('#btnsave').click(function() {
		   var strFromMh = $('#txtfrommh').val();
		   var strToMh =  $('#txttomh').val();
		   var strductno =  $('#txtductno').val();
		   var strdiameter =  $('#txtdiameter').val();
		   var strfromloc =  $('#cbofromloc').val();
		   var strtoloc =  $('#cbotoloc').val();



		   $.ajax({
                 url: 'add_duct.php',
                 type:'POST',
                 data:{ ductno : strductno,frommh : strFromMh,tomh : strToMh,diameter : strdiameter,fromloc : strfromloc,toloc : strtoloc },
                 cache: false,
                 success: function(data){
                          
                              if(data==1) {
                                $.alert('Success!');
                            }

                          }  

            });


        });

});
</script>




<script>
    $(document).ready(function () {
        $('#txtfrommh,#txttomh').typeahead({
            source: function (query, result) {
                $.ajax({
                    url: "autocomplete.php",
					data: 'query=' + query,            
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
						result($.map(data, function (item) {
							return item;
                        }));
                    }
                });
            }
		});
	



    });
</script>



</html>