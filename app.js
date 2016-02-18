'use strict';
var bankingApp = function() {
	// datables initializing 
	$('#customerRecords').DataTable({
                    "paging": true,
                    "aaSorting": [],
                    "lengthChange": false,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "pageLength": 5,
					searching: true
                });
	// initilizations after doucment is ready			
	$(document).ready(function(){
		// Attaching events
		$(document).on('click','#save',function(){
			$('#page_mode').val(3);
			$('#customer').submit();
		});
		$(document).on('click','.delete',function(){
			var id = $(this).parent().attr('id');
			$('#operation_id').val(id);
			$('#page_mode').val(2);
			$('#customer').submit();
		});
		$(document).on('click','.edit',function(){
			var id = $(this).parent().attr('id');
			$('#operation_id').val(id);
			$('#page_mode').val(4);
			$('#customer').submit();
		});
		$(document).on('click','.back',function(){
			window.location.href='bankingCtrl.php'
		});
		$(document).on('click','#update',function(){
			$('#page_mode').val(5);
			$('#customer').submit();
		});
	}); 
}();