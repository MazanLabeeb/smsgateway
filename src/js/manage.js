$(document).ready(function(){
    $(document).on("click",".delete",function(){
        var id = $(this).attr("data-id") ;
        var user = $(this).attr("data-user") ;
        var messages = $(this).attr("data-messages") ;
        var content = "<input type='hidden' name='id' value='"+id+"'>"+"Total SMS : <input type='number' value='"+messages+"' name='messages' />";
        $(".modal-body").html(content);
    });
});

// id messages