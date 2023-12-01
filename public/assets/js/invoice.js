	 $(document).ready(function(){
	$(document).on('click', '#checkAll', function() {          	
		$(".itemRow").prop("checked", this.checked);
	});	
	$(document).on('click', '.itemRow', function() {  	
		if ($('.itemRow:checked').length == $('.itemRow').length) {
			$('#checkAll').prop('checked', true);
		} else {
			$('#checkAll').prop('checked', false);
		}
	});  
	var count = $(".itemRow").length;
	$(document).on('click', '#addRows', function() {
	var fields=$("#input_field_count").val();
		console.log(fields);
		for(var i=0;i<fields;i++)
		{
		count++;
		var htmlRows = '';
		htmlRows += '<tr>';
		htmlRows += '<td><input class="itemRow" type="checkbox"></td>';          
		htmlRows += '<td><input type="text" name="projectCode[]" id="projectCode_'+count+'" class="form-control project_code" autocomplete="off"></td>';
		htmlRows += '<td><input type="text" name="cpi[]" id="cpi_'+count+'" class="form-control cpi" autocomplete="off"></td>';	
		htmlRows += '<td><input type="text" name="quantity[]" id="quantity_'+count+'" class="form-control quantity" autocomplete="off"></td>';  		 
		htmlRows += '<td><input type="text" name="total[]" id="total_'+count+'" class="form-control total" autocomplete="off"></td>';          
		htmlRows += '</tr>';
		$('#invoiceItem').append(htmlRows);			
		}
	}); 
	$(document).on('click', '#removeRows', function(){
		$(".itemRow:checked").each(function() {
			$(this).closest('tr').remove();
		});
		$('#checkAll').prop('checked', false);
		calculateTotal();
	});		
	$(document).on('blur', "[id^=quantity_]", function(){
		calculateTotal();
	});
	$(document).on('click', '.deleteInvoice', function(){
		var id = $(this).attr("id");
		if(confirm("Are you sure you want to remove this?")){
			$.ajax({
				url:"action.php",
				method:"POST",
				dataType: "json",
				data:{id:id, action:'delete_invoice'},				
				success:function(response) {
					if(response.status == 1) {
						$('#'+id).closest("tr").remove();
					}
				}
			});
		} else {
			return false;
		}
	});
});	
function calculateTotal(){
	var totalAmount = 0;
	$("[id^='cpi_']").each(function() {
		var id = $(this).attr('id');
		id = id.replace("cpi_",'');
		var quantity  = $('#quantity_'+id).val();
		var cpi = $('#cpi_' + id).val();
		if(!quantity) {
			quantity = 1;
		}
		$('#total_'+ id).val(cpi * quantity);
		totalAmount += parseFloat($('#total_'+id).val());
		$(".total_amount_usd_text").text(totalAmount);
		$(".total_amount_usd").val(totalAmount);	
		$(".conversion_rate_text").text($("#conversion_rate").val());	
		
		var final_amount=$("#conversion_rate").val()*totalAmount;
		
		//********************************Amount Before GST//************

		$(".total_amount").val(final_amount.toFixed(2));
		$(".total_amount_text").text(final_amount.toFixed(2));

		//********************************GST Amount//************
		var gst_amount=parseFloat(final_amount/118*18).toFixed(2);
		$(".gst_amount_text").text(gst_amount);
		$(".gst_amount").val(gst_amount);

		//********************************Amount Before GST//************
		var bedore_gst=(parseFloat(final_amount-gst_amount)).toFixed(2);
		$(".before_gst_text").text(bedore_gst);
		$(".before_gst").val(bedore_gst);
	});
}