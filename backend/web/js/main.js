$(function(){
	$("#btnAddPhone").click(function(event){
		event.preventDefault();

		$("#modalAddPhone").modal('show').find(".modal-body").load($(this).attr('href'));
		
	});

	$("#btnAddEmail").click(function(event){
		event.preventDefault();

		$("#modalAddEmail").modal('show').find(".modal-body").load($(this).attr('href'));
		
	});
});